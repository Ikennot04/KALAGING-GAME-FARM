import 'package:flutter_bloc/flutter_bloc.dart';
import '../repositories/worker_repository.dart';
import 'workers_event.dart';
import 'workers_state.dart';
import 'dart:async';
import 'dart:io';

class WorkerBloc extends Bloc<WorkerEvent, WorkerState> {
  final WorkerRepository workerRepository;

  WorkerBloc(this.workerRepository) : super(WorkerInitial()) {
    on<FetchWorkersEvent>((event, emit) async {
      emit(WorkerLoading());
      try {
        final workers = await workerRepository.getAllWorkers();
        if (workers.isEmpty) {
          emit(const WorkerError('No workers found'));
        } else {
          emit(WorkerLoaded(workers));
        }
      } on TimeoutException {
        emit(const WorkerError('Connection timeout'));
      } on SocketException {
        emit(const WorkerError('Network error'));
      } catch (e) {
        emit(WorkerError('Failed to fetch workers: $e'));
      }
    });
  }
}
