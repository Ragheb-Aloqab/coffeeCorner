import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'core/theme/app_theme.dart';
import 'providers/cart_order_provider.dart';
import 'providers/catalog_provider.dart';
import 'providers/theme_provider.dart';
import 'views/splash/splash_screen.dart';

void main() {
  runApp(const BrownCoffeeApp());
}

class BrownCoffeeApp extends StatelessWidget {
  const BrownCoffeeApp({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return MultiProvider(
      providers: [
        ChangeNotifierProvider(create: (_) => ThemeProvider()),
        ChangeNotifierProvider(create: (_) => CatalogProvider()),
        ChangeNotifierProvider(create: (_) => CartOrderProvider()),
      ],
      child: Consumer<ThemeProvider>(
        builder: (context, themeProvider, child) {
          return MaterialApp(
            title: 'برون كوفي — Brown Coffee',
            debugShowCheckedModeBanner: false,
            themeMode: themeProvider.themeMode,
            theme: AppTheme.lightTheme,
            darkTheme: AppTheme.darkTheme,
            builder: (context, childWidget) {
              return Directionality(
                textDirection: TextDirection.rtl,
                child: childWidget ?? const SizedBox(),
              );
            },
            home: const SplashScreen(),
          );
        },
      ),
    );
  }
}
