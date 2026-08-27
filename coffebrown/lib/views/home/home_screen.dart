import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:provider/provider.dart';
import '../../core/constants/app_colors.dart';
import '../../core/utils/icon_helper.dart';
import '../../models/product_model.dart';
import '../../providers/cart_order_provider.dart';
import '../../providers/catalog_provider.dart';
import '../cart/cart_checkout_screen.dart';
import '../category/category_screen.dart';
import '../orders/orders_screen.dart';
import '../product/product_detail_screen.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({Key? key}) : super(key: key);

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  int _currentNavIndex = 0;

  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addPostFrameCallback((_) {
      Provider.of<CatalogProvider>(context, listen: false).fetchAllCatalogData();
    });
  }

  void _onBottomNavTapped(int index) {
    if (index == 1) {
      Navigator.push(
        context,
        MaterialPageRoute(builder: (_) => const CategoryScreen(categoryId: 'fatayer')),
      );
    } else if (index == 2) {
      Navigator.push(
        context,
        MaterialPageRoute(builder: (_) => const CartCheckoutScreen()),
      );
    } else if (index == 3) {
      Navigator.push(
        context,
        MaterialPageRoute(builder: (_) => const OrdersScreen()),
      );
    } else {
      setState(() {
        _currentNavIndex = index;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    final catalog = Provider.of<CatalogProvider>(context);
    final cart = Provider.of<CartOrderProvider>(context);

    return Scaffold(
      backgroundColor: AppColors.bgDark,
      appBar: AppBar(
        backgroundColor: AppColors.bgCard,
        elevation: 0,
        title: Row(
          children: [
            Container(
              width: 36,
              height: 36,
              decoration: const BoxDecoration(
                shape: BoxShape.circle,
                color: AppColors.amberPrimary,
              ),
              child: const Icon(FontAwesomeIcons.mugHot, size: 18, color: Colors.black),
            ),
            const SizedBox(width: 10),
            Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: const [
                Text(
                  'برون كوفي',
                  style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: AppColors.amberPrimary),
                ),
                Text(
                  'طازج وجاهز للطلب',
                  style: TextStyle(fontSize: 11, color: AppColors.textMuted),
                ),
              ],
            ),
          ],
        ),
        actions: [
          Stack(
            alignment: Alignment.center,
            children: [
              IconButton(
                icon: const Icon(FontAwesomeIcons.cartShopping, color: AppColors.textMain, size: 20),
                onPressed: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(builder: (_) => const CartCheckoutScreen()),
                  );
                },
              ),
              if (cart.itemCount > 0)
                Positioned(
                  top: 8,
                  left: 8,
                  child: Container(
                    padding: const EdgeInsets.all(4),
                    decoration: const BoxDecoration(
                      color: AppColors.amberPrimary,
                      shape: BoxShape.circle,
                    ),
                    constraints: const BoxConstraints(minWidth: 16, minHeight: 16),
                    child: Text(
                      '${cart.itemCount}',
                      textAlign: TextAlign.center,
                      style: const TextStyle(
                        color: Colors.black,
                        fontSize: 10,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                  ),
                ),
            ],
          ),
          const SizedBox(width: 8),
        ],
      ),
      body: RefreshIndicator(
        onRefresh: () => catalog.fetchAllCatalogData(),
        color: AppColors.amberPrimary,
        backgroundColor: AppColors.bgCard,
        child: catalog.isLoading
            ? const Center(
                child: CircularProgressIndicator(color: AppColors.amberPrimary),
              )
            : catalog.errorMessage != null
                ? Center(
                    child: Padding(
                      padding: const EdgeInsets.all(24.0),
                      child: Column(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          const Icon(FontAwesomeIcons.triangleExclamation, size: 48, color: Colors.redAccent),
                          const SizedBox(height: 16),
                          Text(
                            catalog.errorMessage!,
                            textAlign: TextAlign.center,
                            style: const TextStyle(fontSize: 16, color: AppColors.textMain),
                          ),
                          const SizedBox(height: 20),
                          ElevatedButton.icon(
                            onPressed: () => catalog.fetchAllCatalogData(),
                            icon: const Icon(FontAwesomeIcons.rotateRight, size: 16),
                            label: const Text('إعادة المحاولة'),
                            style: ElevatedButton.styleFrom(
                              backgroundColor: AppColors.amberPrimary,
                              foregroundColor: Colors.black,
                            ),
                          )
                        ],
                      ),
                    ),
                  )
                : CustomScrollView(
                    slivers: [
                      // Search Bar & Greeting
                      SliverToBoxAdapter(
                        child: Padding(
                          padding: const EdgeInsets.all(16.0),
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Row(
                                children: const [
                                  Icon(FontAwesomeIcons.solidHand, size: 16, color: AppColors.amberPrimary),
                                  SizedBox(width: 6),
                                  Text('أهلاً بك في برون كوفي', style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold)),
                                ],
                              ),
                              const SizedBox(height: 12),
                              TextField(
                                onChanged: (val) => catalog.setSearchQuery(val),
                                style: const TextStyle(color: Colors.white, fontSize: 14),
                                decoration: InputDecoration(
                                  hintText: 'ابحث عن قهوة، حلويات، فطائر...',
                                  hintStyle: const TextStyle(color: AppColors.textMuted, fontSize: 14),
                                  prefixIcon: const Icon(FontAwesomeIcons.magnifyingGlass, color: AppColors.textMuted, size: 16),
                                  filled: true,
                                  fillColor: AppColors.bgCard,
                                  contentPadding: const EdgeInsets.symmetric(vertical: 12, horizontal: 16),
                                  border: OutlineInputBorder(
                                    borderRadius: BorderRadius.circular(16),
                                    borderSide: BorderSide(color: AppColors.amberPrimary.withOpacity(0.2)),
                                  ),
                                  enabledBorder: OutlineInputBorder(
                                    borderRadius: BorderRadius.circular(16),
                                    borderSide: BorderSide(color: AppColors.amberPrimary.withOpacity(0.2)),
                                  ),
                                  focusedBorder: OutlineInputBorder(
                                    borderRadius: BorderRadius.circular(16),
                                    borderSide: const BorderSide(color: AppColors.amberPrimary),
                                  ),
                                ),
                              ),
                            ],
                          ),
                        ),
                      ),

                      // Hero Banner
                      SliverToBoxAdapter(
                        child: Padding(
                          padding: const EdgeInsets.symmetric(horizontal: 16.0),
                          child: Container(
                            padding: const EdgeInsets.all(16),
                            decoration: BoxDecoration(
                              color: AppColors.bgCard,
                              borderRadius: BorderRadius.circular(20),
                              border: Border.all(color: AppColors.amberPrimary.withOpacity(0.3)),
                            ),
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Row(
                                  children: const [
                                    Icon(FontAwesomeIcons.crown, size: 14, color: AppColors.amberPrimary),
                                    SizedBox(width: 6),
                                    Text(
                                      'المشروب الأكثر طلباً اليوم',
                                      style: TextStyle(fontSize: 12, fontWeight: FontWeight.bold, color: AppColors.amberPrimary),
                                    ),
                                  ],
                                ),
                                const SizedBox(height: 8),
                                const Text(
                                  'كابتشينو برون كوفي الفاخر',
                                  style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: AppColors.textMain),
                                ),
                                const SizedBox(height: 4),
                                const Text(
                                  'إسبريسو غني مع رغوة حليب مخملية ناعمة لبداية يوم مثالية',
                                  style: TextStyle(fontSize: 12, color: AppColors.textMuted),
                                ),
                                const SizedBox(height: 12),
                                Row(
                                  children: const [
                                    Icon(FontAwesomeIcons.truckFast, size: 14, color: AppColors.matchaGreen),
                                    SizedBox(width: 6),
                                    Text(
                                      'خدمة التوصيل السريع (30 - 45 دقيقة)',
                                      style: TextStyle(fontSize: 11, color: AppColors.matchaGreen, fontWeight: FontWeight.w600),
                                    ),
                                  ],
                                ),
                              ],
                            ),
                          ),
                        ),
                      ),

                      // Section Header: Categories
                      SliverToBoxAdapter(
                        child: Padding(
                          padding: const EdgeInsets.fromLTRB(16, 20, 16, 12),
                          child: Row(
                            children: const [
                              Icon(FontAwesomeIcons.borderAll, size: 16, color: AppColors.amberPrimary),
                              SizedBox(width: 8),
                              Text('أقسام القائمة', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
                            ],
                          ),
                        ),
                      ),

                      // Category Filter Tabs
                      SliverToBoxAdapter(
                        child: SizedBox(
                          height: 44,
                          child: ListView(
                            scrollDirection: Axis.horizontal,
                            padding: const EdgeInsets.symmetric(horizontal: 16),
                            children: [
                              _buildCategoryTab(
                                id: 'all',
                                label: 'الكل',
                                icon: FontAwesomeIcons.borderAll,
                                isSelected: catalog.selectedCategoryId == 'all',
                                onTap: () => catalog.setSelectedCategory('all'),
                              ),
                              ...catalog.categories.map((c) => _buildCategoryTab(
                                    id: c.slug,
                                    label: c.name,
                                    icon: IconHelper.getIconData(c.icon),
                                    isSelected: catalog.selectedCategoryId == c.slug,
                                    onTap: () => catalog.setSelectedCategory(c.slug),
                                  )),
                            ],
                          ),
                        ),
                      ),

                      // Section Header: Products List
                      SliverToBoxAdapter(
                        child: Padding(
                          padding: const EdgeInsets.fromLTRB(16, 20, 16, 12),
                          child: Row(
                            mainAxisAlignment: MainAxisAlignment.spaceBetween,
                            children: [
                              Row(
                                children: [
                                  const Icon(FontAwesomeIcons.utensils, size: 16, color: AppColors.amberPrimary),
                                  const SizedBox(width: 8),
                                  Text(
                                    'المنتجات (${catalog.filteredProducts.length})',
                                    style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
                                  ),
                                ],
                              ),
                            ],
                          ),
                        ),
                      ),

                      // Products Grid
                      catalog.filteredProducts.isEmpty
                          ? SliverToBoxAdapter(
                              child: Padding(
                                padding: const EdgeInsets.all(32.0),
                                child: Column(
                                  children: const [
                                    Icon(FontAwesomeIcons.magnifyingGlass, size: 36, color: AppColors.textMuted),
                                    SizedBox(height: 12),
                                    Text('عذراً، لم نجد أي منتجات تطابق البحث', style: TextStyle(color: AppColors.textMuted)),
                                  ],
                                ),
                              ),
                            )
                          : SliverPadding(
                              padding: const EdgeInsets.symmetric(horizontal: 16),
                              sliver: SliverGrid(
                                delegate: SliverChildBuilderDelegate(
                                  (context, index) {
                                    final product = catalog.filteredProducts[index];
                                    return _buildProductCard(context, product, cart);
                                  },
                                  childCount: catalog.filteredProducts.length,
                                ),
                                gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                                  crossAxisCount: 2,
                                  mainAxisSpacing: 14,
                                  crossAxisSpacing: 14,
                                  childAspectRatio: 0.72,
                                ),
                              ),
                            ),

                      const SliverToBoxAdapter(child: SizedBox(height: 24)),
                    ],
                  ),
      ),
      bottomNavigationBar: BottomNavigationBar(
        currentIndex: _currentNavIndex,
        onTap: _onBottomNavTapped,
        backgroundColor: AppColors.bgCard,
        selectedItemColor: AppColors.amberPrimary,
        unselectedItemColor: AppColors.textMuted,
        type: BottomNavigationBarType.fixed,
        items: const [
          BottomNavigationBarItem(
            icon: Icon(FontAwesomeIcons.house, size: 18),
            label: 'الرئيسية',
          ),
          BottomNavigationBarItem(
            icon: Icon(FontAwesomeIcons.borderAll, size: 18),
            label: 'القائمة',
          ),
          BottomNavigationBarItem(
            icon: Icon(FontAwesomeIcons.cartShopping, size: 18),
            label: 'السلة',
          ),
          BottomNavigationBarItem(
            icon: Icon(FontAwesomeIcons.receipt, size: 18),
            label: 'طلباتي',
          ),
        ],
      ),
    );
  }

  Widget _buildCategoryTab({
    required String id,
    required String label,
    required IconData icon,
    required bool isSelected,
    required VoidCallback onTap,
  }) {
    return Padding(
      padding: const EdgeInsets.only(left: 8.0),
      child: InkWell(
        onTap: onTap,
        borderRadius: BorderRadius.circular(12),
        child: Container(
          padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 8),
          decoration: BoxDecoration(
            color: isSelected ? AppColors.amberPrimary : AppColors.bgCard,
            borderRadius: BorderRadius.circular(12),
            border: Border.all(
              color: isSelected ? AppColors.amberPrimary : AppColors.amberPrimary.withOpacity(0.2),
            ),
          ),
          child: Row(
            children: [
              Icon(icon, size: 14, color: isSelected ? Colors.black : AppColors.amberPrimary),
              const SizedBox(width: 6),
              Text(
                label,
                style: TextStyle(
                  fontSize: 13,
                  fontWeight: FontWeight.bold,
                  color: isSelected ? Colors.black : AppColors.textMain,
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildProductCard(BuildContext context, ProductModel product, CartOrderProvider cart) {
    return GestureDetector(
      onTap: () {
        Navigator.push(
          context,
          MaterialPageRoute(builder: (_) => ProductDetailScreen(productId: product.id)),
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
            // Product Image or Icon
            Expanded(
              child: Stack(
                children: [
                  ClipRRect(
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
                  if (product.hasMatchaAddon)
                    Positioned(
                      top: 8,
                      right: 8,
                      child: Container(
                        padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                        decoration: BoxDecoration(
                          color: AppColors.matchaGreen,
                          borderRadius: BorderRadius.circular(8),
                        ),
                        child: Row(
                          children: const [
                            Icon(FontAwesomeIcons.leaf, size: 10, color: Colors.white),
                            SizedBox(width: 4),
                            Text(
                              'ماتشا',
                              style: TextStyle(fontSize: 10, fontWeight: FontWeight.bold, color: Colors.white),
                            ),
                          ],
                        ),
                      ),
                    ),
                ],
              ),
            ),

            // Product Details
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
                      Text(
                        '${product.rating}',
                        style: const TextStyle(fontSize: 11, fontWeight: FontWeight.bold, color: AppColors.textMain),
                      ),
                      const SizedBox(width: 4),
                      Text(
                        '(${product.reviews})',
                        style: const TextStyle(fontSize: 10, color: AppColors.textMuted),
                      ),
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
                              behavior: SnackBarBehavior.floating,
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
