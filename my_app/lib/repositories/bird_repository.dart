import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/bird_model.dart';

class BirdRepository {
  final String baseUrl = 'http://localhost:8000/api';

  Future<List<Bird>> fetchBirds() async {
    try {
      final response = await http.get(Uri.parse('$baseUrl/birds'));
      
      if (response.statusCode == 200) {
        final Map<String, dynamic> data = json.decode(response.body);
        final List<dynamic> birdsJson = data['birds'];
        return birdsJson.map((json) => Bird.fromJson(json)).toList();
      } else {
        throw Exception('Failed to load birds');
      }
    } catch (e) {
      throw Exception('Failed to connect to the server');
    }
  }
} 