import 'package:equatable/equatable.dart';

abstract class WorkerEvent extends Equatable {
  const WorkerEvent();

  @override
  List<Object?> get props => [];
}

class FetchWorkersEvent extends WorkerEvent {}
