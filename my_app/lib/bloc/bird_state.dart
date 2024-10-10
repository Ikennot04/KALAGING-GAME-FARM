import 'package:equatable/equatable.dart';
import '../models/bird_model.dart';

abstract class BirdState extends Equatable {
  const BirdState();

  @override
  List<Object> get props => [];
}

class BirdInitial extends BirdState {}

class BirdLoadSuccess extends BirdState {
  final List<Bird> birds;

  BirdLoadSuccess(this.birds);

  @override
  List<Object> get props => [birds];
}
