import 'package:http/http.dart' as http;
import 'dart:convert';

class DashboardRepository {
  static const baseUrl = 'http://127.0.0.1:8000/api';

  Future<Map<String, dynamic>> getDashboardStats() async {
    final response = await http.get(Uri.parse('$baseUrl/dashboard/stats'));
    
    if (response.statusCode == 200) {
      return json.decode(response.body);
    } else {
      throw Exception('Failed to load dashboard stats');
    }
  }
}