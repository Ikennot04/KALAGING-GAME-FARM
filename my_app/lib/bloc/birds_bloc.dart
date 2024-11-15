import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:my_app/bloc/birds_event.dart';
import 'package:my_app/bloc/birds_state.dart';
import 'package:my_app/models/bird_model.dart'; // Import the Bird model.


class BirdBloc extends Bloc<BirdEvent, BirdState> {
  BirdBloc() : super(BirdInitial()) {
    // Register the event handler here
    on<LoadBirds>((event, emit) {
      emit(BirdLoaded(birds: Bird.birds)); // Load your list of birds here.
    });
  }
}