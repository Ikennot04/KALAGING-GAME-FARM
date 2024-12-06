import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:my_app/bloc/birds_event.dart';
import 'package:my_app/bloc/birds_state.dart';
import 'package:my_app/models/bird_model.dart'; // Import the Bird model.
import 'package:my_app/repositories/bird_repository.dart';


class BirdBloc extends Bloc<BirdEvent, BirdState> {
  final BirdRepository repository;

  BirdBloc({required this.repository}) : super(BirdInitial()) {
    on<LoadBirds>((event, emit) async {
      emit(BirdLoading());
      try {
        final birds = await repository.fetchBirds();
        emit(BirdLoaded(birds: birds));
      } catch (e) {
        emit(BirdError(message: e.toString()));
      }
    });
  }
}