class ApiConstants {
  // Base API URL (pointing to Laravel Backend)
  static const String baseUrl = 'http://localhost:8000/api/v1';

  // Endpoints
  static const String register = '/auth/register';
  static const String login = '/auth/login';
  static const String profile = '/auth/profile';
  static const String categories = '/categories';
  static const String products = '/products';
  static const String offers = '/offers';
  static const String settings = '/settings';
  static const String orders = '/orders';
}
