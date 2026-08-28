import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:provider/provider.dart';
import '../../core/constants/app_colors.dart';
import '../../providers/cart_order_provider.dart';
import '../cart/cart_checkout_screen.dart';
import '../category/category_screen.dart';
import '../home/home_screen.dart';
import '../../providers/theme_provider.dart';

class MainNavigationShell extends StatefulWidget {
  final int initialIndex;
  const MainNavigationShell({Key? key, this.initialIndex = 0}) : super(key: key);

  @override
  State<MainNavigationShell> createState() => _MainNavigationShellState();
}

class _MainNavigationShellState extends State<MainNavigationShell> {
  late int _currentIndex;

  @override
  void initState() {
    super.initState();
    _currentIndex = widget.initialIndex;
  }

  void _onTabTapped(int index) {
    setState(() {
      _currentIndex = index;
    });
  }

  @override
  Widget build(BuildContext context) {
    final theme = Provider.of<ThemeProvider>(context);
    final cart = Provider.of<CartOrderProvider>(context);

    final List<Widget> pages = [
      const HomeViewContent(),
      const CategoryScreen(categoryId: 'fatayer', isEmbedded: true),
      const CartCheckoutScreen(isEmbedded: true),
      const OrdersScreen(isEmbedded: true),
    ];

    return Scaffold(
      backgroundColor: theme.bgDark,
      body: IndexedStack(
        index: _currentIndex,
        children: pages,
      ),
      bottomNavigationBar: Container(
        color: theme.bgDark,
        padding: const EdgeInsets.fromLTRB(16, 6, 16, 16),
        child: Container(
          height: 66,
          decoration: BoxDecoration(
            color: theme.bgCard,
            borderRadius: BorderRadius.circular(24),
            border: Border.all(color: theme.amberPrimary.withOpacity(0.3), width: 1.5),
            boxShadow: [
              BoxShadow(
                color: Colors.black.withOpacity(theme.isDarkMode ? 0.4 : 0.08),
                blurRadius: 16,
                offset: const Offset(0, 6),
              ),
              BoxShadow(
                color: theme.amberPrimary.withOpacity(0.08),
                blurRadius: 10,
                spreadRadius: 1,
              ),
            ],
          ),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceAround,
            children: [
              _buildNavItem(
                context: context,
                theme: theme,
                index: 0,
                label: 'الرئيسية',
                icon: FontAwesomeIcons.house,
                isActive: _currentIndex == 0,
              ),
              _buildNavItem(
                context: context,
                theme: theme,
                index: 1,
                label: 'القائمة',
                icon: FontAwesomeIcons.borderAll,
                isActive: _currentIndex == 1,
              ),
              _buildNavItem(
                context: context,
                theme: theme,
                index: 2,
                label: 'السلة',
                icon: FontAwesomeIcons.cartShopping,
                isActive: _currentIndex == 2,
                badgeCount: cart.itemCount,
              ),
              _buildNavItem(
                context: context,
                theme: theme,
                index: 3,
                label: 'طلباتي',
                icon: FontAwesomeIcons.receipt,
                isActive: _currentIndex == 3,
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildNavItem({
    required BuildContext context,
    required ThemeProvider theme,
    required int index,
    required String label,
    required IconData icon,
    required bool isActive,
    int badgeCount = 0,
  }) {
    return InkWell(
      onTap: () => _onTabTapped(index),
      borderRadius: BorderRadius.circular(18),
      child: AnimatedContainer(
        duration: const Duration(milliseconds: 250),
        padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 8),
        decoration: BoxDecoration(
          color: isActive ? theme.amberPrimary.withOpacity(0.18) : Colors.transparent,
          borderRadius: BorderRadius.circular(18),
          border: Border.all(
            color: isActive ? theme.amberPrimary.withOpacity(0.5) : Colors.transparent,
            width: 1,
          ),
        ),
        child: Row(
          mainAxisSize: MainAxisSize.min,
          children: [
            Stack(
              clipBehavior: Clip.none,
              children: [
                Icon(
                  icon,
                  size: 18,
                  color: isActive ? theme.amberPrimary : theme.textMuted,
                ),
                if (badgeCount > 0)
                  Positioned(
                    top: -6,
                    right: -8,
                    child: Container(
                      padding: const EdgeInsets.all(3),
                      decoration: BoxDecoration(
                        color: theme.amberPrimary,
                        shape: BoxShape.circle,
                      ),
                      constraints: const BoxConstraints(minWidth: 14, minHeight: 14),
                      child: Text(
                        '$badgeCount',
                        textAlign: TextAlign.center,
                        style: const TextStyle(
                          color: Colors.black,
                          fontSize: 9,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                    ),
                  ),
              ],
            ),
            if (isActive) ...[
              const SizedBox(width: 8),
              Text(
                label,
                style: TextStyle(
                  fontSize: 13,
                  fontWeight: FontWeight.bold,
                  color: theme.amberPrimary,
                ),
              ),
            ],
          ],
        ),
      ),
    );
  }
}
