import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import '../constants/app_colors.dart';

class AppTheme {
  static ThemeData get darkTheme {
    return ThemeData(
      brightness: Brightness.dark,
      scaffoldBackgroundColor: AppColors.bgDark,
      primaryColor: AppColors.amberPrimary,
      cardColor: AppColors.bgCard,
      colorScheme: const ColorScheme.dark(
        primary: AppColors.amberPrimary,
        surface: AppColors.bgCard,
        background: AppColors.bgDark,
      ),
      textTheme: GoogleFonts.ibmPlexSansArabicTextTheme(
        ThemeData.dark().textTheme,
      ).apply(
        bodyColor: AppColors.textMain,
        displayColor: AppColors.textMain,
      ),
      useMaterial3: true,
    );
  }
}
