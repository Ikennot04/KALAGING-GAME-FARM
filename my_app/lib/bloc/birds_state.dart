abstract class BirdState {}

class BirdInitialState extends BirdState {}

class BirdLoadingState extends BirdState {}

class BirdLoadedState extends BirdState {
  final List<dynamic> birds;

  BirdLoadedState(this.birds);
}

class BirdErrorState extends BirdState {
  final String error;

  BirdErrorState(this.error);
}
