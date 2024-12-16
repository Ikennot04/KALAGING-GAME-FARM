import 'package:equatable/equatable.dart';
import '../models/worker_model.dart';

abstract class WorkerState extends Equatable {
  const WorkerState();

  @override
  List<Object?> get props => [];
}

class WorkerInitial extends WorkerState {}

class WorkerLoading extends WorkerState {}

class WorkerLoaded extends WorkerState {
  final List<Worker> workers;

  const WorkerLoaded(this.workers);

  @override
  List<Object?> get props => [workers];
}

class WorkerError extends WorkerState {
  final String message;

  const WorkerError(this.message);

  @override
  List<Object?> get props => [message];
}
