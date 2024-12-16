import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../pages/bird/bird_details.dart';
import '../bloc/birds_event.dart';
import '../bloc/birds_bloc.dart';

class AppRoutes {
  static Map<String, Widget Function(BuildContext)> routes = {
    '/bird-details': (context) {
      final args = ModalRoute.of(context)?.settings.arguments as Map<String, dynamic>?;
      if (args == null) {
        return Scaffold(
          appBar: AppBar(title: Text('Error')),
          body: Center(child: Text('Invalid bird details')),
        );
      }
      return BlocProvider(
        create: (context) => BirdBloc()..add(FetchBirdsEvent()),
        child: BirdDetailsPage(birdId: args['birdId']),
      );
    },
  };
} 