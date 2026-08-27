import 'package:flutter/material.dart';
import '../core/constants/api_constants.dart';
import '../core/network/api_client.dart';
import '../models/order_model.dart';
import '../models/product_model.dart';

class CartItem {
  final int cartId;
  final ProductModel product;
  int quantity;
  bool addonMatcha;

  CartItem({
    required this.cartId,
    required this.product,
    this.quantity = 1,
    this.addonMatcha = false,
  });

  double get unitPrice => product.price + (addonMatcha ? 5.0 : 0.0);
  double get lineTotal => unitPrice * quantity;
}

class CartOrderProvider extends ChangeNotifier {
  final List<CartItem> _cartItems = [];
  List<OrderModel> _userOrders = [];
  OrderModel? _activeOrder;

  int _cartIdCounter = 1;
  bool _isSubmitting = false;

  List<CartItem> get cartItems => _cartItems;
  List<OrderModel> get userOrders => _userOrders;
  OrderModel? get activeOrder => _activeOrder;
  bool get isSubmitting => _isSubmitting;

  double get subtotal => _cartItems.fold(0.0, (sum, i) => sum + i.lineTotal);
  int get itemCount => _cartItems.fold(0, (sum, i) => sum + i.quantity);

  double get minOrderAmount => 30.0;
  bool get isMinOrderMet => subtotal >= minOrderAmount;
  double get remainingForMinOrder => (minOrderAmount - subtotal).clamp(0.0, minOrderAmount);

  void addToCart(ProductModel product, {int quantity = 1, bool addonMatcha = false}) {
    final existingIndex = _cartItems.indexWhere(
      (item) => item.product.id == product.id && item.addonMatcha == addonMatcha,
    );

    if (existingIndex >= 0) {
      _cartItems[existingIndex].quantity += quantity;
    } else {
      _cartItems.add(
        CartItem(
          cartId: _cartIdCounter++,
          product: product,
          quantity: quantity,
          addonMatcha: addonMatcha,
        ),
      );
    }
    notifyListeners();
  }

  void updateQuantity(int cartId, int delta) {
    final item = _cartItems.firstWhere((i) => i.cartId == cartId);
    item.quantity += delta;
    if (item.quantity <= 0) {
      _cartItems.removeWhere((i) => i.cartId == cartId);
    }
    notifyListeners();
  }

  void removeCartItem(int cartId) {
    _cartItems.removeWhere((i) => i.cartId == cartId);
    notifyListeners();
  }

  void clearCart() {
    _cartItems.clear();
    notifyListeners();
  }

  Future<OrderModel> submitOrder({
    required String customerName,
    required String customerPhone,
    String? deliveryAddress,
    String paymentMethod = 'cash',
    String? notes,
  }) async {
    if (!isMinOrderMet) {
      throw Exception('الحد الأدنى للطلب هو $minOrderAmount ر.س');
    }

    _isSubmitting = true;
    notifyListeners();

    try {
      final List<Map<String, dynamic>> itemsPayload = _cartItems.map((item) {
        return {
          'product_id': item.product.id,
          'quantity': item.quantity,
          'addon_matcha': item.addonMatcha,
        };
      }).toList();

      final payload = {
        'customer_name': customerName,
        'customer_phone': customerPhone,
        'delivery_address': deliveryAddress ?? 'توصيل لباب البيت',
        'payment_method': paymentMethod,
        'notes': notes,
        'items': itemsPayload,
      };

      final response = await ApiClient.post(ApiConstants.orders, payload);

      if (response['success'] == true) {
        final order = OrderModel.fromJson(response['data']);
        _activeOrder = order;
        _userOrders.insert(0, order);
        clearCart();
        return order;
      } else {
        throw Exception(response['message'] ?? 'فشل في إنشاء الطلب');
      }
    } finally {
      _isSubmitting = false;
      notifyListeners();
    }
  }

  Future<void> fetchUserOrders(String phone) async {
    try {
      final response = await ApiClient.get(ApiConstants.orders, queryParameters: {'phone': phone});
      if (response['success'] == true) {
        _userOrders = (response['data'] as List).map((i) => OrderModel.fromJson(i)).toList();
        notifyListeners();
      }
    } catch (_) {}
  }

  Future<void> trackOrder(String orderNumber) async {
    try {
      final response = await ApiClient.get('${ApiConstants.orders}/$orderNumber');
      if (response['success'] == true) {
        _activeOrder = OrderModel.fromJson(response['data']);
        notifyListeners();
      }
    } catch (_) {}
  }
}
