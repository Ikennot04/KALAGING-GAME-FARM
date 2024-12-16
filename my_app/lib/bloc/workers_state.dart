import 'package:equatable/equatable.dart';

abstract class WorkerState extends Equatable {
  const WorkerState();

  @override
  List<Object?> get props => [];
}

class WorkerInitialState extends WorkerState {}

class WorkerLoadingState extends WorkerState {}

class WorkerLoadedState extends WorkerState {
  final List<dynamic> workers;

  const WorkerLoadedState(this.workers);

  @override
  List<Object?> get props => [workers];
}

class WorkerErrorState extends WorkerState {
  final String error;

  const WorkerErrorState(this.error);

  @override
  List<Object?> get props => [error];
}
