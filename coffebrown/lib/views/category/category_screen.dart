import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:provider/provider.dart';
import '../../core/constants/app_colors.dart';
import '../../core/utils/icon_helper.dart';
import '../../models/product_model.dart';
import '../../providers/cart_order_provider.dart';
import '../../providers/catalog_provider.dart';
import '../cart/cart_checkout_screen.dart';
import '../product/product_detail_screen.dart';
import '../../core/utils/page_transitions.dart';

import '../../providers/theme_provider.dart';

class CategoryScreen extends StatelessWidget {
  final String categoryId;
  final bool isEmbedded;

  const CategoryScreen({Key? key, required this.categoryId, this.isEmbedded = false}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final theme = Provider.of<ThemeProvider>(context);
    final catalog = Provider.of<CatalogProvider>(context);
    final cart = Provider.of<CartOrderProvider>(context);

    final category = catalog.categories.firstWhere(
      (c) => c.slug == categoryId || c.id.toString() == categoryId,
      orElse: () => catalog.categories.isNotEmpty
          ? catalog.categories.first
          : throw Exception('القسم غير موجود'),
    );

    final categoryProducts = catalog.filteredProducts.where((p) {
      return p.categoryId == category.id || p.category?.slug == category.slug;
    }).toList();

    return Scaffold(
      backgroundColor: theme.bgDark,
      appBar: AppBar(
        backgroundColor: theme.bgCard,
        elevation: 0,
        automaticallyImplyLeading: !isEmbedded,
        leading: isEmbedded
            ? null
            : IconButton(
                icon: const Icon(FontAwesomeIcons.chevronRight, color: AppColors.textMain, size: 18),
                onPressed: () => Navigator.pop(context),
              ),
        title: Row(
          children: [
            Icon(IconHelper.getIconData(category.icon), size: 18, color: AppColors.amberPrimary),
            const SizedBox(width: 8),
            Text(category.name, style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: AppColors.textMain)),
          ],
        ),
        actions: [
          IconButton(
            icon: const Icon(FontAwesomeIcons.cartShopping, color: AppColors.textMain, size: 20),
            onPressed: () {
              Navigator.push(
                context,
                MaterialPageRoute(builder: (_) => const CartCheckoutScreen()),
              );
            },
          ),
          const SizedBox(width: 8),
        ],
      ),
      body: categoryProducts.isEmpty
          ? Center(
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: const [
                  Icon(FontAwesomeIcons.magnifyingGlass, size: 40, color: AppColors.textMuted),
                  SizedBox(height: 12),
                  Text('لا توجد منتجات متوفرة في هذا القسم حالياً', style: TextStyle(color: AppColors.textMuted)),
                ],
              ),
            )
          : GridView.builder(
              padding: const EdgeInsets.all(16),
              gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                crossAxisCount: 2,
                mainAxisSpacing: 14,
                crossAxisSpacing: 14,
                childAspectRatio: 0.72,
              ),
              itemCount: categoryProducts.length,
              itemBuilder: (context, index) {
                final product = categoryProducts[index];
                return _buildProductCard(context, product, cart);
              },
            ),
    );
  }

  Widget _buildProductCard(BuildContext context, ProductModel product, CartOrderProvider cart) {
    return GestureDetector(
      onTap: () {
        PageTransitions.pushSmooth(
          context,
          ProductDetailScreen(productId: product.id),
        );
      },
      child: Container(
        decoration: BoxDecoration(
          color: AppColors.bgCard,
          borderRadius: BorderRadius.circular(16),
          border: Border.all(color: AppColors.amberPrimary.withOpacity(0.15)),
        ),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Expanded(
              child: Hero(
                tag: 'product_image_${product.id}',
                child: ClipRRect(
                  borderRadius: const BorderRadius.vertical(top: Radius.circular(16)),
                  child: product.image != null && product.image!.isNotEmpty
                      ? Image.network(
                          product.image!,
                          width: double.infinity,
                          height: double.infinity,
                          fit: BoxFit.cover,
                          errorBuilder: (_, __, ___) => _buildFallbackImage(product),
                        )
                      : _buildFallbackImage(product),
                ),
              ),
            ),
            Padding(
              padding: const EdgeInsets.all(10.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    product.name,
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                    style: const TextStyle(fontSize: 14, fontWeight: FontWeight.bold, color: AppColors.textMain),
                  ),
                  const SizedBox(height: 4),
                  Row(
                    children: [
                      const Icon(FontAwesomeIcons.solidStar, size: 11, color: AppColors.amberPrimary),
                      const SizedBox(width: 4),
                      Text('${product.rating}', style: const TextStyle(fontSize: 11, fontWeight: FontWeight.bold, color: AppColors.textMain)),
                      const SizedBox(width: 4),
                      Text('(${product.reviews})', style: const TextStyle(fontSize: 10, color: AppColors.textMuted)),
                    ],
                  ),
                  const SizedBox(height: 8),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Text(
                        '${product.price.toStringAsFixed(2)} ر.س',
                        style: const TextStyle(fontSize: 13, fontWeight: FontWeight.bold, color: AppColors.amberPrimary),
                      ),
                      InkWell(
                        onTap: () {
                          cart.addToCart(product, quantity: 1);
                          ScaffoldMessenger.of(context).showSnackBar(
                            SnackBar(
                              content: Row(
                                children: const [
                                  Icon(FontAwesomeIcons.circleCheck, color: Colors.black, size: 16),
                                  SizedBox(width: 8),
                                  Text('تمت الإضافة إلى السلة!', style: TextStyle(color: Colors.black, fontWeight: FontWeight.bold)),
                                ],
                              ),
                              backgroundColor: AppColors.amberPrimary,
                              duration: const Duration(seconds: 1),
                            ),
                          );
                        },
                        child: Container(
                          padding: const EdgeInsets.all(8),
                          decoration: BoxDecoration(
                            color: AppColors.amberPrimary,
                            borderRadius: BorderRadius.circular(10),
                          ),
                          child: const Icon(FontAwesomeIcons.plus, size: 12, color: Colors.black),
                        ),
                      ),
                    ],
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
      width: double.infinity,
      height: double.infinity,
      child: Center(
        child: Icon(
          IconHelper.getIconData(product.icon),
          size: 40,
          color: AppColors.amberPrimary.withOpacity(0.6),
        ),
      ),
    );
  }
}
