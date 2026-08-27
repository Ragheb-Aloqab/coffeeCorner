import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:provider/provider.dart';
import '../../core/constants/app_colors.dart';
import '../../core/utils/icon_helper.dart';
import '../../models/product_model.dart';
import '../../providers/cart_order_provider.dart';
import '../../providers/catalog_provider.dart';

class ProductDetailScreen extends StatefulWidget {
  final int productId;

  const ProductDetailScreen({Key? key, required this.productId}) : super(key: key);

  @override
  State<ProductDetailScreen> createState() => _ProductDetailScreenState();
}

class _ProductDetailScreenState extends State<ProductDetailScreen> {
  int _quantity = 1;
  bool _matchaAddonSelected = false;

  void _incrementQty() {
    setState(() {
      _quantity++;
    });
  }

  void _decrementQty() {
    if (_quantity > 1) {
      setState(() {
        _quantity--;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    final catalog = Provider.of<CatalogProvider>(context);
    final cart = Provider.of<CartOrderProvider>(context);
    final product = catalog.getProductById(widget.productId);

    if (product == null) {
      return Scaffold(
        backgroundColor: AppColors.bgDark,
        appBar: AppBar(backgroundColor: AppColors.bgCard),
        body: const Center(child: Text('المنتج غير موجود')),
      );
    }

    final double unitPrice = product.price + (_matchaAddonSelected ? 5.0 : 0.0);
    final double totalPrice = unitPrice * _quantity;

    return Scaffold(
      backgroundColor: AppColors.bgDark,
      body: SafeArea(
        child: Column(
          children: [
            // Top Bar Overlay
            Padding(
              padding: const EdgeInsets.all(12.0),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  IconButton(
                    icon: const Icon(FontAwesomeIcons.chevronRight, color: Colors.white, size: 20),
                    onPressed: () => Navigator.pop(context),
                  ),
                  const Text('تفاصيل المنتج', style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold)),
                  const SizedBox(width: 40),
                ],
              ),
            ),

            Expanded(
              child: SingleChildScrollView(
                padding: const EdgeInsets.all(16.0),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    // Hero Product Image Container
                    Container(
                      height: 250,
                      width: double.infinity,
                      decoration: BoxDecoration(
                        color: AppColors.bgCard,
                        borderRadius: BorderRadius.circular(24),
                        border: Border.all(color: AppColors.amberPrimary.withOpacity(0.2)),
                      ),
                      child: ClipRRect(
                        borderRadius: BorderRadius.circular(24),
                        child: product.image != null && product.image!.isNotEmpty
                            ? Image.network(
                                product.image!,
                                fit: BoxFit.cover,
                                errorBuilder: (_, __, ___) => _buildFallbackImage(product),
                              )
                            : _buildFallbackImage(product),
                      ),
                    ),
                    const SizedBox(height: 20),

                    // Title & Category Badge
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        Expanded(
                          child: Text(
                            product.name,
                            style: const TextStyle(fontSize: 24, fontWeight: FontWeight.bold, color: AppColors.textMain),
                          ),
                        ),
                        Row(
                          children: [
                            const Icon(FontAwesomeIcons.solidStar, size: 14, color: AppColors.amberPrimary),
                            const SizedBox(width: 6),
                            Text(
                              '${product.rating}',
                              style: const TextStyle(fontSize: 14, fontWeight: FontWeight.bold),
                            ),
                            const SizedBox(width: 4),
                            Text(
                              '(${product.reviews})',
                              style: const TextStyle(fontSize: 12, color: AppColors.textMuted),
                            ),
                          ],
                        ),
                      ],
                    ),
                    const SizedBox(height: 12),

                    // Description
                    if (product.desc != null && product.desc!.isNotEmpty)
                      Text(
                        product.desc!,
                        style: const TextStyle(fontSize: 14, color: AppColors.textMuted, height: 1.5),
                      ),
                    const SizedBox(height: 24),

                    // Optional Matcha Addon
                    if (product.hasMatchaAddon) ...[
                      Container(
                        padding: const EdgeInsets.all(16),
                        decoration: BoxDecoration(
                          color: AppColors.bgCard,
                          borderRadius: BorderRadius.circular(16),
                          border: Border.all(color: AppColors.matchaGreen.withOpacity(0.4)),
                        ),
                        child: Row(
                          children: [
                            const Icon(FontAwesomeIcons.leaf, size: 24, color: AppColors.matchaGreen),
                            const SizedBox(width: 14),
                            Expanded(
                              child: Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: const [
                                  Text(
                                    'إضافة ماتشا يابانية فاخرة',
                                    style: TextStyle(fontSize: 15, fontWeight: FontWeight.bold, color: Colors.white),
                                  ),
                                  SizedBox(height: 2),
                                  Text(
                                    'خلطة ماتشا مركزة تُضاف إلى مشروبك (+5.00 ر.س)',
                                    style: TextStyle(fontSize: 12, color: AppColors.textMuted),
                                  ),
                                ],
                              ),
                            ),
                            Switch(
                              value: _matchaAddonSelected,
                              activeColor: AppColors.matchaGreen,
                              onChanged: (val) {
                                setState(() {
                                  _matchaAddonSelected = val;
                                });
                              },
                            ),
                          ],
                        ),
                      ),
                      const SizedBox(height: 24),
                    ],

                    // Quantity Counter Row
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        const Text('الكمية المطلوب طلبها', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
                        Container(
                          decoration: BoxDecoration(
                            color: AppColors.bgCard,
                            borderRadius: BorderRadius.circular(14),
                            border: Border.all(color: AppColors.amberPrimary.withOpacity(0.2)),
                          ),
                          child: Row(
                            children: [
                              IconButton(
                                icon: const Icon(FontAwesomeIcons.minus, size: 14, color: AppColors.amberPrimary),
                                onPressed: _decrementQty,
                              ),
                              Padding(
                                padding: const EdgeInsets.symmetric(horizontal: 12.0),
                                child: Text(
                                  '$_quantity',
                                  style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                                ),
                              ),
                              IconButton(
                                icon: const Icon(FontAwesomeIcons.plus, size: 14, color: AppColors.amberPrimary),
                                onPressed: _incrementQty,
                              ),
                            ],
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),
            ),

            // Bottom Add to Cart Action Bar
            Container(
              padding: const EdgeInsets.all(16),
              decoration: BoxDecoration(
                color: AppColors.bgCard,
                borderRadius: const BorderRadius.vertical(top: Radius.circular(24)),
                border: Border.all(color: AppColors.amberPrimary.withOpacity(0.2)),
              ),
              child: Row(
                children: [
                  Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      const Text('الإجمالي الكلي', style: TextStyle(fontSize: 12, color: AppColors.textMuted)),
                      Text(
                        '${totalPrice.toStringAsFixed(2)} ر.س',
                        style: const TextStyle(fontSize: 20, fontWeight: FontWeight.bold, color: AppColors.amberPrimary),
                      ),
                    ],
                  ),
                  const SizedBox(width: 20),
                  Expanded(
                    child: SizedBox(
                      height: 52,
                      child: ElevatedButton.icon(
                        onPressed: () {
                          cart.addToCart(product, quantity: _quantity, addonMatcha: _matchaAddonSelected);
                          Navigator.pop(context);
                          ScaffoldMessenger.of(context).showSnackBar(
                            SnackBar(
                              content: Row(
                                children: const [
                                  Icon(FontAwesomeIcons.circleCheck, color: Colors.black, size: 16),
                                  SizedBox(width: 8),
                                  Text('تمت الإضافة إلى السلة بنجاح!', style: TextStyle(color: Colors.black, fontWeight: FontWeight.bold)),
                                ],
                              ),
                              backgroundColor: AppColors.amberPrimary,
                              duration: const Duration(seconds: 2),
                            ),
                          );
                        },
                        icon: const Icon(FontAwesomeIcons.cartPlus, size: 16),
                        label: const Text('أضف إلى السلة', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
                        style: ElevatedButton.styleFrom(
                          backgroundColor: AppColors.amberPrimary,
                          foregroundColor: Colors.black,
                          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
                        ),
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildFallbackImage(ProductModel product) {
    return Container(
      color: AppColors.bgDark,
      child: Center(
        child: Icon(
          IconHelper.getIconData(product.icon),
          size: 64,
          color: AppColors.amberPrimary.withOpacity(0.6),
        ),
      ),
    );
  }
}
