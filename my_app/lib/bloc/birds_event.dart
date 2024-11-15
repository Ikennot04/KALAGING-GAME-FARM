import 'package:equatable/equatable.dart';

abstract class BirdEvent extends Equatable {
  const BirdEvent();

  @override
  List<Object> get props => [];
}

class LoadBirds extends BirdEvent {}
