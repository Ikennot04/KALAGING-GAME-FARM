import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/worker_model.dart';
import 'dart:async';
import 'dart:io';


class WorkerRepository {
  final String baseUrl = 'http://127.0.0.1:8000/api';

  Future<List<Worker>> getAllWorkers() async {
    try {
      final response = await http
          .get(Uri.parse('$baseUrl/workers'))
          .timeout(const Duration(seconds: 10));

      if (response.statusCode == 200) {
        final List<dynamic> data = json.decode(response.body)['workers'];
        return data.map((worker) => Worker.fromJson(worker)).toList();
      } else {
        throw Exception('Server error: ${response.statusCode}');
      }
    } on TimeoutException {
      throw Exception('Connection timeout');
    } on SocketException {
      throw Exception('Network error');
    } catch (e) {
      throw Exception('Failed to load workers: $e');
    }
  }
}
