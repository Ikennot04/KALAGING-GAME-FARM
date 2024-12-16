import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../pages/bird/bird_details.dart';
import '../bloc/birds_event.dart';
import '../bloc/birds_bloc.dart';
import '../pages/worker/worker_details.dart';
import '../bloc/workers_bloc.dart';
import '../bloc/workers_event.dart';
import '../repositories/worker_repository.dart';

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
    '/worker-details': (context) {
      final args = ModalRoute.of(context)?.settings.arguments as Map<String, dynamic>?;
      if (args == null) {
        return Scaffold(
          appBar: AppBar(title: Text('Error')),
          body: Center(child: Text('Invalid worker details')),
        );
      }
      return BlocProvider(
        create: (context) => WorkerBloc(WorkerRepository())..add(FetchWorkersEvent()),
        child: WorkerDetailsPage(workerId: args['workerId']),
      );
    },
  };
} 