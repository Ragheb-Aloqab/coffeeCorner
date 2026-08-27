class OrderItemModel {
  final int id;
  final int productId;
  final String name;
  final double unitPrice;
  final int qty;
  final Map<String, dynamic>? addonDetails;
  final double lineTotal;

  OrderItemModel({
    required this.id,
    required this.productId,
    required this.name,
    required this.unitPrice,
    required this.qty,
    this.addonDetails,
    required this.lineTotal,
  });

  factory OrderItemModel.fromJson(Map<String, dynamic> json) {
    return OrderItemModel(
      id: json['id'] ?? 0,
      productId: json['productId'] ?? json['product_id'] ?? 0,
      name: json['name'] ?? json['product_name'] ?? '',
      unitPrice: (json['unitPrice'] ?? json['unit_price'] as num?)?.toDouble() ?? 0.0,
      qty: json['qty'] ?? json['quantity'] ?? 1,
      addonDetails: json['addonDetails'] ?? json['addon_details'],
      lineTotal: (json['lineTotal'] ?? json['line_total'] as num?)?.toDouble() ?? 0.0,
    );
  }
}

class OrderModel {
  final int id;
  final String orderNumber;
  final String customerName;
  final String customerPhone;
  final String? deliveryAddress;
  final double subtotal;
  final double discount;
  final double deliveryFee;
  final double totalAmount;
  final String status; // pending, preparing, out_for_delivery, delivered, cancelled
  final String paymentMethod;
  final String paymentStatus;
  final String? notes;
  final List<OrderItemModel> items;
  final String? createdAt;

  OrderModel({
    required this.id,
    required this.orderNumber,
    required this.customerName,
    required this.customerPhone,
    this.deliveryAddress,
    required this.subtotal,
    required this.discount,
    required this.deliveryFee,
    required this.totalAmount,
    required this.status,
    required this.paymentMethod,
    required this.paymentStatus,
    this.notes,
    required this.items,
    this.createdAt,
  });

  factory OrderModel.fromJson(Map<String, dynamic> json) {
    return OrderModel(
      id: json['id'] ?? 0,
      orderNumber: json['orderNumber'] ?? json['order_number'] ?? '',
      customerName: json['customerName'] ?? json['customer_name'] ?? '',
      customerPhone: json['customerPhone'] ?? json['customer_phone'] ?? '',
      deliveryAddress: json['deliveryAddress'] ?? json['delivery_address'],
      subtotal: (json['subtotal'] as num?)?.toDouble() ?? 0.0,
      discount: (json['discount'] as num?)?.toDouble() ?? 0.0,
      deliveryFee: (json['deliveryFee'] ?? json['delivery_fee'] as num?)?.toDouble() ?? 0.0,
      totalAmount: (json['totalAmount'] ?? json['total_amount'] as num?)?.toDouble() ?? 0.0,
      status: json['status'] ?? 'pending',
      paymentMethod: json['paymentMethod'] ?? json['payment_method'] ?? 'cash',
      paymentStatus: json['paymentStatus'] ?? json['payment_status'] ?? 'pending',
      notes: json['notes'],
      items: json['items'] != null
          ? (json['items'] as List).map((i) => OrderItemModel.fromJson(i)).toList()
          : [],
      createdAt: json['createdAt'] ?? json['created_at'],
    );
  }
}
