import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'bloc/bird_bloc.dart';
import 'repository/bird_repository.dart';
import 'ui/bird_list_screen.dart';

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  final BirdRepository birdRepository = BirdRepository();

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: BlocProvider(
        create: (context) => BirdBloc(birdRepository: birdRepository),
        child: BirdListScreen(),
      ),
    );
  }
}
