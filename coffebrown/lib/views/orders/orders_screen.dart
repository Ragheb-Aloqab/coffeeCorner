import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:provider/provider.dart';
import '../../core/constants/app_colors.dart';
import '../../models/order_model.dart';
import '../../providers/cart_order_provider.dart';

class OrdersScreen extends StatefulWidget {
  const OrdersScreen({Key? key}) : super(key: key);

  @override
  State<OrdersScreen> createState() => _OrdersScreenState();
}

class _OrdersScreenState extends State<OrdersScreen> {
  final _phoneController = TextEditingController(text: '0551234567');

  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addPostFrameCallback((_) {
      Provider.of<CartOrderProvider>(context, listen: false).fetchUserOrders(_phoneController.text.trim());
    });
  }

  @override
  void dispose() {
    _phoneController.dispose();
    super.dispose();
  }

  void _searchOrders() {
    if (_phoneController.text.trim().isNotEmpty) {
      Provider.of<CartOrderProvider>(context, listen: false).fetchUserOrders(_phoneController.text.trim());
    }
  }

  @override
  Widget build(BuildContext context) {
    final cart = Provider.of<CartOrderProvider>(context);

    return Scaffold(
      backgroundColor: AppColors.bgDark,
      appBar: AppBar(
        backgroundColor: AppColors.bgCard,
        elevation: 0,
        leading: IconButton(
          icon: const Icon(FontAwesomeIcons.chevronRight, color: AppColors.textMain, size: 18),
          onPressed: () => Navigator.pop(context),
        ),
        title: const Text('طلباتي وتتبع حالة الطلب', style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: AppColors.textMain)),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Search Phone Input
            Row(
              children: [
                Expanded(
                  child: TextField(
                    controller: _phoneController,
                    keyboardType: TextInputType.phone,
                    style: const TextStyle(fontSize: 14, color: Colors.white),
                    decoration: InputDecoration(
                      hintText: 'أدخل رقم الهاتف لتتبع طلباتك...',
                      hintStyle: const TextStyle(color: AppColors.textMuted, fontSize: 13),
                      prefixIcon: const Icon(FontAwesomeIcons.phone, size: 14, color: AppColors.amberPrimary),
                      filled: true,
                      fillColor: AppColors.bgCard,
                      contentPadding: const EdgeInsets.symmetric(horizontal: 14, vertical: 10),
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(14),
                        borderSide: BorderSide(color: AppColors.amberPrimary.withOpacity(0.2)),
                      ),
                    ),
                  ),
                ),
                const SizedBox(width: 8),
                ElevatedButton.icon(
                  onPressed: _searchOrders,
                  icon: const Icon(FontAwesomeIcons.magnifyingGlass, size: 14),
                  label: const Text('بحث'),
                  style: ElevatedButton.styleFrom(
                    backgroundColor: AppColors.amberPrimary,
                    foregroundColor: Colors.black,
                    padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 14),
                    shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(14)),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 20),

            // Active Order Banner if available
            if (cart.activeOrder != null) ...[
              const Text('الطلب الحالي الجاري تحضيره', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
              const SizedBox(height: 10),
              _buildOrderCard(cart.activeOrder!, isActive: true),
              const SizedBox(height: 24),
            ],

            // User Orders List Header
            const Text('سجل الطلبات', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
            const SizedBox(height: 12),

            cart.userOrders.isEmpty
                ? Center(
                    child: Padding(
                      padding: const EdgeInsets.all(32.0),
                      child: Column(
                        children: const [
                          Icon(FontAwesomeIcons.receipt, size: 48, color: AppColors.textMuted),
                          SizedBox(height: 12),
                          Text('لا توجد طلبات سابقة مسجلة لرقم الهاتف هذا', style: TextStyle(color: AppColors.textMuted)),
                        ],
                      ),
                    ),
                  )
                : ListView.separated(
                    shrinkWrap: true,
                    physics: const NeverScrollableScrollPhysics(),
                    itemCount: cart.userOrders.length,
                    separatorBuilder: (_, __) => const SizedBox(height: 12),
                    itemBuilder: (context, index) {
                      final order = cart.userOrders[index];
                      return _buildOrderCard(order);
                    },
                  ),
          ],
        ),
      ),
    );
  }

  Widget _buildOrderCard(OrderModel order, {bool isActive = false}) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: AppColors.bgCard,
        borderRadius: BorderRadius.circular(18),
        border: Border.all(
          color: isActive ? AppColors.amberPrimary : AppColors.amberPrimary.withOpacity(0.15),
          width: isActive ? 1.5 : 1,
        ),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Order Number & Status Badge
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text(
                order.orderNumber,
                style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: AppColors.amberPrimary),
              ),
              _buildStatusBadge(order.status),
            ],
          ),
          const SizedBox(height: 10),

          // Customer Info
          Text('العميل: ${order.customerName}', style: const TextStyle(fontSize: 13, color: AppColors.textMain)),
          const SizedBox(height: 2),
          Text('عنوان التوصيل: ${order.deliveryAddress ?? 'توصيل لباب البيت'}', style: const TextStyle(fontSize: 12, color: AppColors.textMuted)),
          const Divider(height: 20, color: Colors.white10),

          // Order Items List
          Column(
            children: order.items.map((item) {
              return Padding(
                padding: const EdgeInsets.symmetric(vertical: 2.0),
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Text(
                      '${item.name} ×${item.qty}',
                      style: const TextStyle(fontSize: 13, color: AppColors.textMain),
                    ),
                    Text(
                      '${item.lineTotal.toStringAsFixed(2)} ر.س',
                      style: const TextStyle(fontSize: 13, fontWeight: FontWeight.bold),
                    ),
                  ],
                ),
              );
            }).toList(),
          ),
          const Divider(height: 20, color: Colors.white10),

          // Footer Total
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text(
                order.createdAt ?? '',
                style: const TextStyle(fontSize: 11, color: AppColors.textMuted),
              ),
              Text(
                'المجموع: ${order.totalAmount.toStringAsFixed(2)} ر.س',
                style: const TextStyle(fontSize: 15, fontWeight: FontWeight.bold, color: AppColors.amberPrimary),
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildStatusBadge(String status) {
    Color bg = AppColors.statusPending.withOpacity(0.2);
    Color fg = AppColors.statusPending;
    IconData icon = FontAwesomeIcons.hourglassHalf;
    String label = 'قيد الانتظار';

    if (status == 'preparing') {
      bg = AppColors.statusPreparing.withOpacity(0.2);
      fg = AppColors.statusPreparing;
      icon = FontAwesomeIcons.fire;
      label = 'جاري التحضير';
    } else if (status == 'out_for_delivery') {
      bg = AppColors.statusOutForDelivery.withOpacity(0.2);
      fg = AppColors.statusOutForDelivery;
      icon = FontAwesomeIcons.truckFast;
      label = 'خرج للتوصيل';
    } else if (status == 'delivered') {
      bg = AppColors.statusDelivered.withOpacity(0.2);
      fg = AppColors.statusDelivered;
      icon = FontAwesomeIcons.circleCheck;
      label = 'تم التوصيل';
    } else if (status == 'cancelled') {
      bg = AppColors.statusCancelled.withOpacity(0.2);
      fg = AppColors.statusCancelled;
      icon = FontAwesomeIcons.circleXmark;
      label = 'ملغي';
    }

    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
      decoration: BoxDecoration(
        color: bg,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: fg.withOpacity(0.4)),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Icon(icon, size: 12, color: fg),
          const SizedBox(width: 4),
          Text(
            label,
            style: TextStyle(fontSize: 11, fontWeight: FontWeight.bold, color: fg),
          ),
        ],
      ),
    );
  }
}
