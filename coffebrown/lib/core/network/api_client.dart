import 'dart:convert';
import 'package:http/http.dart' as http;
import '../constants/api_constants.dart';

class ApiClient {
  static final Map<String, String> _headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  };

  static Future<dynamic> get(String endpoint, {Map<String, String>? queryParameters}) async {
    try {
      final Uri uri = Uri.parse('${ApiConstants.baseUrl}$endpoint').replace(queryParameters: queryParameters);
      final response = await http.get(uri, headers: _headers);
      return _processResponse(response);
    } catch (e) {
      throw Exception('تعذر الاتصال بالخادم: $e');
    }
  }

  static Future<dynamic> post(String endpoint, Map<String, dynamic> body) async {
    try {
      final Uri uri = Uri.parse('${ApiConstants.baseUrl}$endpoint');
      final response = await http.post(uri, headers: _headers, body: jsonEncode(body));
      return _processResponse(response);
    } catch (e) {
      throw Exception('تعذر الاتصال بالخادم: $e');
    }
  }

  static dynamic _processResponse(http.Response response) {
    final Map<String, dynamic> body = jsonDecode(response.body);
    if (response.statusCode >= 200 && response.statusCode < 300) {
      return body;
    } else {
      final String message = body['message'] ?? 'حدث خطأ في معالجة الطلب (${response.statusCode})';
      throw Exception(message);
    }
  }
}
