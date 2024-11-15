import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:my_app/bloc/birds_bloc.dart';
import 'package:my_app/bloc/birds_event.dart';
import 'package:my_app/bloc/birds_state.dart';

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        primarySwatch: Colors.blue,
        visualDensity: VisualDensity.adaptivePlatformDensity,
      ),
      home: BlocProvider(
        create: (context) => BirdBloc()..add(LoadBirds()),
        child: BirdScreen(),
      ),
    );
  }
}

class BirdScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Birds'),
        centerTitle: true,
        
      ),
      body: BlocBuilder<BirdBloc, BirdState>(
        builder: (context, state) {
          if (state is BirdInitial) {
            return Center(child: CircularProgressIndicator());
          } else if (state is BirdLoaded) {
            return Padding(
              padding: const EdgeInsets.all(16.0),
              child: ListView.builder(
                itemCount: state.birds.length,
                itemBuilder: (context, index) {
                  final bird = state.birds[index];
                  return Card(
                    margin: const EdgeInsets.symmetric(vertical: 8.0),
                    elevation: 4,
                    child: ListTile(
                      contentPadding: const EdgeInsets.all(16.0),
                      title: Text(
                        bird.description,
                        style: TextStyle(fontWeight: FontWeight.bold),
                      ),
                      subtitle: Text(bird.owner),
                      leading: ClipOval(
                        child: SizedBox(
                          height: 50,
                          width: 50,
                          child: bird.image,
                        ),
                      ),
                    ),
                  );
                },
              ),
            );
          }
          return Center(child: Text('Something went wrong'));
        },
      ),
    );
  }
}


