import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class AppTheme {
  // Dark Luxury Theme
  static ThemeData get darkTheme {
    return ThemeData(
      brightness: Brightness.dark,
      scaffoldBackgroundColor: const Color(0xFF1E1214),
      primaryColor: const Color(0xFFC8963E),
      cardColor: const Color(0xFF2C1A1D),
      colorScheme: const ColorScheme.dark(
        primary: Color(0xFFC8963E),
        surface: Color(0xFF2C1A1D),
        background: Color(0xFF1E1214),
      ),
      textTheme: GoogleFonts.ibmPlexSansArabicTextTheme(
        ThemeData.dark().textTheme,
      ).apply(
        bodyColor: const Color(0xFFF3EBE1),
        displayColor: const Color(0xFFF3EBE1),
      ),
      useMaterial3: true,
    );
  }

  // Light Theme (White background with crisp dark text)
  static ThemeData get lightTheme {
    return ThemeData(
      brightness: Brightness.light,
      scaffoldBackgroundColor: const Color(0xFFF8FAFC),
      primaryColor: const Color(0xFFB37F2A),
      cardColor: const Color(0xFFFFFFFF),
      colorScheme: const ColorScheme.light(
        primary: Color(0xFFB37F2A),
        surface: Color(0xFFFFFFFF),
        background: Color(0xFFF8FAFC),
      ),
      textTheme: GoogleFonts.ibmPlexSansArabicTextTheme(
        ThemeData.light().textTheme,
      ).apply(
        bodyColor: const Color(0xFF0F172A),
        displayColor: const Color(0xFF0F172A),
      ),
      useMaterial3: true,
    );
  }
}
