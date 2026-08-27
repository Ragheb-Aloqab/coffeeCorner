import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:provider/provider.dart';
import '../../core/constants/app_colors.dart';
import '../../providers/cart_order_provider.dart';
import '../orders/orders_screen.dart';

class CartCheckoutScreen extends StatefulWidget {
  const CartCheckoutScreen({Key? key}) : super(key: key);

  @override
  State<CartCheckoutScreen> createState() => _CartCheckoutScreenState();
}

class _CartCheckoutScreenState extends State<CartCheckoutScreen> {
  final _nameController = TextEditingController(text: 'أحمد علي');
  final _phoneController = TextEditingController(text: '0551234567');
  final _addressController = TextEditingController(text: 'الرياض - حي الملقا - شارع حائل');
  final _notesController = TextEditingController();

  @override
  void dispose() {
    _nameController.dispose();
    _phoneController.dispose();
    _addressController.dispose();
    _notesController.dispose();
    super.dispose();
  }

  void _onConfirmOrder(CartOrderProvider cart) async {
    if (_nameController.text.trim().isEmpty || _phoneController.text.trim().isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('يرجى تقديم الاسم ورقم الهاتف للمتابعة'),
          backgroundColor: Colors.redAccent,
        ),
      );
      return;
    }

    try {
      final order = await cart.submitOrder(
        customerName: _nameController.text.trim(),
        customerPhone: _phoneController.text.trim(),
        deliveryAddress: _addressController.text.trim(),
        notes: _notesController.text.trim(),
      );

      if (!mounted) return;

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Row(
            children: const [
              Icon(FontAwesomeIcons.circleCheck, color: Colors.black, size: 16),
              SizedBox(width: 8),
              Text('تم تأكيد الطلب بنجاح وهو قيد التحضير!', style: TextStyle(color: Colors.black, fontWeight: FontWeight.bold)),
            ],
          ),
          backgroundColor: AppColors.amberPrimary,
        ),
      );

      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (_) => const OrdersScreen()),
      );
    } catch (e) {
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(e.toString().replaceAll('Exception: ', '')),
          backgroundColor: Colors.redAccent,
        ),
      );
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
        title: const Text('سلة الشراء وإتمام الطلب', style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: AppColors.textMain)),
      ),
      body: cart.cartItems.isEmpty
          ? Center(
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  const Icon(FontAwesomeIcons.cartShopping, size: 54, color: AppColors.textMuted),
                  const SizedBox(height: 16),
                  const Text('سلتك فارغة', style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold)),
                  const SizedBox(height: 8),
                  const Text('تصفح قائمة الطعام وأضف ما يعجبك للبدء في طلبك', style: TextStyle(color: AppColors.textMuted)),
                  const SizedBox(height: 24),
                  ElevatedButton.icon(
                    onPressed: () => Navigator.pop(context),
                    icon: const Icon(FontAwesomeIcons.utensils, size: 16),
                    label: const Text('تصفح القائمة'),
                    style: ElevatedButton.styleFrom(
                      backgroundColor: AppColors.amberPrimary,
                      foregroundColor: Colors.black,
                      padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 12),
                    ),
                  )
                ],
              ),
            )
          : SingleChildScrollView(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // Minimum Order Bar Progress Card
                  Container(
                    padding: const EdgeInsets.all(14),
                    decoration: BoxDecoration(
                      color: cart.isMinOrderMet ? AppColors.matchaGreen.withOpacity(0.15) : AppColors.amberPrimary.withOpacity(0.15),
                      borderRadius: BorderRadius.circular(16),
                      border: Border.all(
                        color: cart.isMinOrderMet ? AppColors.matchaGreen : AppColors.amberPrimary,
                      ),
                    ),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Row(
                          children: [
                            Icon(
                              cart.isMinOrderMet ? FontAwesomeIcons.circleCheck : FontAwesomeIcons.circleExclamation,
                              size: 16,
                              color: cart.isMinOrderMet ? AppColors.matchaGreen : AppColors.amberPrimary,
                            ),
                            const SizedBox(width: 8),
                            Expanded(
                              child: Text(
                                cart.isMinOrderMet
                                    ? 'تم الوصول للحد الأدنى للطلب (30 ر.س)'
                                    : 'الحد الأدنى للطلب هو 30.00 ر.س (باقي ${cart.remainingForMinOrder.toStringAsFixed(2)} ر.س)',
                                style: TextStyle(
                                  fontSize: 13,
                                  fontWeight: FontWeight.bold,
                                  color: cart.isMinOrderMet ? AppColors.matchaGreen : AppColors.amberPrimary,
                                ),
                              ),
                            ),
                          ],
                        ),
                        const SizedBox(height: 8),
                        ClipRRect(
                          borderRadius: BorderRadius.circular(8),
                          child: LinearProgressIndicator(
                            value: (cart.subtotal / cart.minOrderAmount).clamp(0.0, 1.0),
                            backgroundColor: Colors.black/20,
                            valueColor: AlwaysStoppedAnimation<Color>(
                              cart.isMinOrderMet ? AppColors.matchaGreen : AppColors.amberPrimary,
                            ),
                            minHeight: 6,
                          ),
                        ),
                      ],
                    ),
                  ),
                  const SizedBox(height: 20),

                  // Cart Items List
                  const Text('المنتجات المحددة', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
                  const SizedBox(height: 12),
                  ListView.separated(
                    shrinkWrap: true,
                    physics: const NeverScrollableScrollPhysics(),
                    itemCount: cart.cartItems.length,
                    separatorBuilder: (_, __) => const SizedBox(height: 10),
                    itemBuilder: (context, index) {
                      final item = cart.cartItems[index];
                      return Container(
                        padding: const EdgeInsets.all(12),
                        decoration: BoxDecoration(
                          color: AppColors.bgCard,
                          borderRadius: BorderRadius.circular(16),
                          border: Border.all(color: AppColors.amberPrimary.withOpacity(0.15)),
                        ),
                        child: Row(
                          children: [
                            Container(
                              width: 50,
                              height: 50,
                              decoration: BoxDecoration(
                                color: AppColors.bgDark,
                                borderRadius: BorderRadius.circular(12),
                              ),
                              child: const Icon(FontAwesomeIcons.mugHot, color: AppColors.amberPrimary, size: 24),
                            ),
                            const SizedBox(width: 12),
                            Expanded(
                              child: Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Text(item.product.name, style: const TextStyle(fontSize: 14, fontWeight: FontWeight.bold)),
                                  if (item.addonMatcha)
                                    Row(
                                      children: const [
                                        Icon(FontAwesomeIcons.leaf, size: 10, color: AppColors.matchaGreen),
                                        SizedBox(width: 4),
                                        Text('إضافة ماتشا (+5.00 ر.س)', style: TextStyle(fontSize: 11, color: AppColors.matchaGreen)),
                                      ],
                                    ),
                                  Text(
                                    '${item.unitPrice.toStringAsFixed(2)} ر.س / قطعة',
                                    style: const TextStyle(fontSize: 11, color: AppColors.textMuted),
                                  ),
                                ],
                              ),
                            ),
                            Row(
                              children: [
                                IconButton(
                                  icon: const Icon(FontAwesomeIcons.minus, size: 12, color: AppColors.amberPrimary),
                                  onPressed: () => cart.updateQuantity(item.cartId, -1),
                                ),
                                Text('${item.quantity}', style: const TextStyle(fontSize: 14, fontWeight: FontWeight.bold)),
                                IconButton(
                                  icon: const Icon(FontAwesomeIcons.plus, size: 12, color: AppColors.amberPrimary),
                                  onPressed: () => cart.updateQuantity(item.cartId, 1),
                                ),
                              ],
                            ),
                            IconButton(
                              icon: const Icon(FontAwesomeIcons.trashCan, size: 14, color: Colors.redAccent),
                              onPressed: () => cart.removeCartItem(item.cartId),
                            ),
                          ],
                        ),
                      );
                    },
                  ),
                  const SizedBox(height: 24),

                  // Customer Details Form
                  const Text('بيانات توصيل الطلب', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
                  const SizedBox(height: 12),
                  _buildTextField(_nameController, 'اسمك الكريم', FontAwesomeIcons.user),
                  const SizedBox(height: 10),
                  _buildTextField(_phoneController, 'رقم الهاتف', FontAwesomeIcons.phone, keyboardType: TextInputType.phone),
                  const SizedBox(height: 10),
                  _buildTextField(_addressController, 'عنوان التوصيل', FontAwesomeIcons.locationDot),
                  const SizedBox(height: 10),
                  _buildTextField(_notesController, 'ملاحظات إضافية (اختياري)', FontAwesomeIcons.noteSticky),
                  const SizedBox(height: 24),

                  // Order Summary Card
                  Container(
                    padding: const EdgeInsets.all(16),
                    decoration: BoxDecoration(
                      color: AppColors.bgCard,
                      borderRadius: BorderRadius.circular(16),
                      border: Border.all(color: AppColors.amberPrimary.withOpacity(0.2)),
                    ),
                    child: Column(
                      children: [
                        Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            const Text('المجموع الفرعي', style: TextStyle(color: AppColors.textMuted)),
                            Text('${cart.subtotal.toStringAsFixed(2)} ر.س', style: const TextStyle(fontWeight: FontWeight.bold)),
                          ],
                        ),
                        const SizedBox(height: 8),
                        Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: const [
                            Text('خدمة التوصيل السريع', style: TextStyle(color: AppColors.textMuted)),
                            Text('مجاناً', style: TextStyle(color: AppColors.matchaGreen, fontWeight: FontWeight.bold)),
                          ],
                        ),
                        const Divider(height: 20, color: Colors.white10),
                        Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            const Text('الإجمالي الكلي', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
                            Text(
                              '${cart.subtotal.toStringAsFixed(2)} ر.س',
                              style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: AppColors.amberPrimary),
                            ),
                          ],
                        ),
                      ],
                    ),
                  ),
                  const SizedBox(height: 24),

                  // Submit Order Button
                  SizedBox(
                    width: double.infinity,
                    height: 54,
                    child: ElevatedButton.icon(
                      onPressed: cart.isMinOrderMet && !cart.isSubmitting
                          ? () => _onConfirmOrder(cart)
                          : null,
                      icon: cart.isSubmitting
                          ? const SizedBox(
                              width: 18,
                              height: 18,
                              child: CircularProgressIndicator(strokeWidth: 2, color: Colors.black),
                            )
                          : const Icon(FontAwesomeIcons.check, size: 16),
                      label: Text(
                        cart.isSubmitting ? 'جاري تأكيد الطلب...' : 'تأكيد الطلب الآن',
                        style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                      ),
                      style: ElevatedButton.styleFrom(
                        backgroundColor: AppColors.amberPrimary,
                        foregroundColor: Colors.black,
                        disabledBackgroundColor: Colors.grey.withOpacity(0.3),
                        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
                      ),
                    ),
                  ),
                ],
              ),
            ),
    );
  }

  Widget _buildTextField(TextEditingController controller, String hint, IconData icon, {TextInputType keyboardType = TextInputType.text}) {
    return TextField(
      controller: controller,
      keyboardType: keyboardType,
      style: const TextStyle(fontSize: 14, color: Colors.white),
      decoration: InputDecoration(
        hintText: hint,
        hintStyle: const TextStyle(color: AppColors.textMuted, fontSize: 14),
        prefixIcon: Icon(icon, size: 14, color: AppColors.amberPrimary),
        filled: true,
        fillColor: AppColors.bgCard,
        contentPadding: const EdgeInsets.symmetric(horizontal: 14, vertical: 12),
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(14),
          borderSide: BorderSide(color: AppColors.amberPrimary.withOpacity(0.2)),
        ),
        enabledBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(14),
          borderSide: BorderSide(color: AppColors.amberPrimary.withOpacity(0.2)),
        ),
        focusedBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(14),
          borderSide: const BorderSide(color: AppColors.amberPrimary),
        ),
      ),
    );
  }
}
