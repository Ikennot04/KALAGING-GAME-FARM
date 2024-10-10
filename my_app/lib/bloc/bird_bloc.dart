import 'package:flutter_bloc/flutter_bloc.dart';
import 'bird_event.dart';
import 'bird_state.dart';
import '../repository/bird_repository.dart';

class BirdBloc extends Bloc<BirdEvent, BirdState> {
  final BirdRepository birdRepository;

  BirdBloc({required this.birdRepository}) : super(BirdInitial()) {
    on<AddBird>(_onAddBird);
    on<DeleteBird>(_onDeleteBird);
  }

  void _onAddBird(AddBird event, Emitter<BirdState> emit) {
    birdRepository.addBird(event.bird);
    emit(BirdLoadSuccess(birdRepository.getAllBirds()));
  }

  void _onDeleteBird(DeleteBird event, Emitter<BirdState> emit) {
    birdRepository.deleteBird(event.birdId);
    emit(BirdLoadSuccess(birdRepository.getAllBirds()));
  }
}
