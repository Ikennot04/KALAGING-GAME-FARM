abstract class BirdEvent {}

class FetchBirdsEvent extends BirdEvent {}

class SearchBirdsEvent extends BirdEvent {
  final String query;
  SearchBirdsEvent(this.query);
}
