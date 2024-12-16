import 'package:flutter_bloc/flutter_bloc.dart';
import '../repositories/worker_repository.dart';
import 'workers_event.dart';
import 'workers_state.dart';
import 'dart:async';
import 'dart:io';
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'dart:developer' as developer;

class WorkerBloc extends Bloc<WorkerEvent, WorkerState> {
  final WorkerRepository workerRepository;
  final client = http.Client();
  static const baseUrl = 'http://127.0.0.1:8000/api';
  static const timeout = Duration(seconds: 10);

  WorkerBloc(this.workerRepository) : super(WorkerInitialState()) {
    on<FetchWorkersEvent>((event, emit) async {
      emit(WorkerLoadingState());
      try {
        final workers = await workerRepository.getAllWorkers();
        if (workers.isEmpty) {
          emit(const WorkerErrorState('No workers found'));
        } else {
          emit(WorkerLoadedState(workers));
        }
      } on TimeoutException {
        emit(const WorkerErrorState('Connection timeout'));
      } on SocketException {
        emit(const WorkerErrorState('Network error'));
      } catch (e) {
        emit(WorkerErrorState('Failed to fetch workers: $e'));
      }
    });

    on<SearchWorkersEvent>((event, emit) async {
      if (event.query.isEmpty) {
        try {
          final response = await client
              .get(Uri.parse('$baseUrl/workers'))
              .timeout(timeout);

          if (response.statusCode == 200) {
            final decoded = json.decode(response.body);
            if (decoded is Map && decoded.containsKey('workers')) {
              final workers = decoded['workers'] as List;
              emit(WorkerLoadedState(workers));
            }
          }
        } catch (e) {
          developer.log('Error fetching workers', name: 'WorkerBloc', error: e);
        }
        return;
      }

      if (event.query.length < 2) {
        return;
      }

      try {
        final response = await client
            .get(Uri.parse('$baseUrl/workers/search?search=${Uri.encodeComponent(event.query)}&type=text'))
            .timeout(timeout);

        if (response.statusCode == 200) {
          final data = json.decode(response.body);
          
          List<dynamic> searchResults = [];
          if (data['match'] != null) {
            searchResults.add(data['match']);
          }
          if (data['related'] != null && data['related'].isNotEmpty) {
            searchResults.addAll(data['related']);
          }
          
          emit(WorkerLoadedState(searchResults));
        }
      } catch (e) {
        emit(WorkerErrorState('Search failed: ${e.toString()}'));
      }
    });
  }
}
