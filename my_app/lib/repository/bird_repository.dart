// lib/repository/bird_repository.dart
import '../models/bird_model.dart';  // Import the Bird model

class BirdRepository {
  List<Bird> birds = [];

  List<Bird> getAllBirds() {
    return birds;
  }

  void addBird(Bird bird) {
    birds.add(bird);
  }

  void deleteBird(String id) {
    birds.removeWhere((bird) => bird.id == id);
  }
}
