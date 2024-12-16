import 'package:bloc/bloc.dart';
import 'birds_event.dart';
import 'birds_state.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'dart:developer' as developer;
import 'dart:io';
import 'dart:async';

class BirdBloc extends Bloc<BirdEvent, BirdState> {
  final client = http.Client();
  static const baseUrl = 'http://127.0.0.1:8000/api';
  static const timeout = Duration(seconds: 10);

  BirdBloc() : super(BirdInitialState()) {
    on<FetchBirdsEvent>((event, emit) async {
      developer.log('Fetching birds from API...', name: 'BirdBloc');
      emit(BirdLoadingState());

      try {
        final response = await client
            .get(Uri.parse('$baseUrl/birds'))
            .timeout(timeout);

        developer.log('Response status: ${response.statusCode}', name: 'BirdBloc');

        if (response.statusCode == 200) {
          final rawResponse = response.body;
          developer.log('Raw response body: $rawResponse', name: 'BirdBloc');
          
          if (rawResponse.isEmpty) {
            developer.log('Received empty response body', name: 'BirdBloc');
            emit(BirdErrorState('Received empty response from the server'));
            return;
          }

          final decoded = json.decode(rawResponse);
          
          if (decoded is Map && decoded.containsKey('birds')) {
            final birds = decoded['birds'] as List;
            developer.log('Received ${birds.length} birds', name: 'BirdBloc');
            emit(BirdLoadedState(birds));
          } else {
            developer.log('Unexpected format: $decoded', name: 'BirdBloc');
            emit(BirdErrorState('Unexpected response format from server'));
          }
        } else {
          developer.log('Received error status: ${response.statusCode}', name: 'BirdBloc');
          emit(BirdErrorState('Server error: ${response.statusCode}'));
        }
      } on SocketException catch (e) {
        developer.log('Network error', name: 'BirdBloc', error: e);
        emit(BirdErrorState('Network error: Please check your connection'));
      } on TimeoutException catch (e) {
        developer.log('Timeout error', name: 'BirdBloc', error: e);
        emit(BirdErrorState('Request timed out. Please try again'));
      } on FormatException catch (e) {
        developer.log('Data parsing error', name: 'BirdBloc', error: e);
        emit(BirdErrorState('Error parsing data from server'));
      } catch (e, stackTrace) {
        developer.log(
          'Unexpected error',
          name: 'BirdBloc',
          error: e.toString(),
          stackTrace: stackTrace,
        );
        emit(BirdErrorState('Unexpected error: ${e.toString()}'));
      }
    });
  }

  @override
  Future<void> close() async {
    client.close();
    return super.close();
  }
}
