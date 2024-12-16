import 'package:equatable/equatable.dart';

abstract class WorkerEvent extends Equatable {
  const WorkerEvent();

  @override
  List<Object?> get props => [];
}

class FetchWorkersEvent extends WorkerEvent {}

class SearchWorkersEvent extends WorkerEvent {
  final String query;
  SearchWorkersEvent(this.query);

  @override
  List<Object?> get props => [query];
}
