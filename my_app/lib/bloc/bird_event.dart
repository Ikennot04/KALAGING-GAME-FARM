import 'package:equatable/equatable.dart';
import '../models/bird_model.dart';

abstract class BirdEvent extends Equatable {
  const BirdEvent();

  @override
  List<Object> get props => [];
}

class AddBird extends BirdEvent {
  final Bird bird;

  AddBird(this.bird);

  @override
  List<Object> get props => [bird];
}

class DeleteBird extends BirdEvent {
  final String birdId;

  DeleteBird(this.birdId);

  @override
  List<Object> get props => [birdId];
}
