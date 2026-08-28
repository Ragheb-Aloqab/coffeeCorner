import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../core/constants/app_colors.dart';

class ThemeProvider extends ChangeNotifier {
  ThemeMode _themeMode = ThemeMode.dark;

  ThemeMode get themeMode => _themeMode;
  bool get isDarkMode => _themeMode == ThemeMode.dark;

  ThemeProvider() {
    _loadThemeFromPrefs();
  }

  // Active Dynamic Colors depending on dark or light mode
  Color get bgDark => isDarkMode ? const Color(0xFF1E1214) : const Color(0xFFF8FAFC);
  Color get bgCard => isDarkMode ? const Color(0xFF2C1A1D) : const Color(0xFFFFFFFF);
  Color get bgInput => isDarkMode ? const Color(0xFF231416) : const Color(0xFFF1F5F9);
  Color get textMain => isDarkMode ? const Color(0xFFF3EBE1) : const Color(0xFF0F172A);
  Color get textMuted => isDarkMode ? const Color(0xFFA3938F) : const Color(0xFF475569);
  Color get border => isDarkMode ? const Color(0xFFC8963E).withOpacity(0.2) : const Color(0xFFE2E8F0);
  Color get amberPrimary => isDarkMode ? const Color(0xFFC8963E) : const Color(0xFFB37F2A);

  Future<void> _loadThemeFromPrefs() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final savedTheme = prefs.getString('app_theme_mode');
      if (savedTheme == 'light') {
        _themeMode = ThemeMode.light;
      } else {
        _themeMode = ThemeMode.dark;
      }
      notifyListeners();
    } catch (_) {}
  }

  Future<void> toggleTheme() async {
    if (_themeMode == ThemeMode.dark) {
      _themeMode = ThemeMode.light;
    } else {
      _themeMode = ThemeMode.dark;
    }
    notifyListeners();

    try {
      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('app_theme_mode', _themeMode == ThemeMode.light ? 'light' : 'dark');
    } catch (_) {}
  }
}
