import 'package:equatable/equatable.dart';
import 'package:my_app/models/bird_model.dart'; // Make sure to import your Bird model here.

abstract class BirdState extends Equatable {
  const BirdState();

  @override
  List<Object> get props => [];
}

class BirdInitial extends BirdState {}

class BirdLoaded extends BirdState {
  final List<Bird> birds;

  const BirdLoaded({required this.birds});

  @override
  List<Object> get props => [birds];
}
