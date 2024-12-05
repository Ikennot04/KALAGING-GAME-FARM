import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:my_app/bloc/birds_bloc.dart';
import 'package:my_app/bloc/birds_event.dart';
import 'package:my_app/bloc/birds_state.dart';
import 'package:my_app/repositories/bird_repository.dart';

void main() {
  runApp(
    MultiBlocProvider(
      providers: [
        BlocProvider(
          create: (context) => BirdBloc(
            repository: BirdRepository(),
          )..add(LoadBirds()),
        ),
      ],
      child: MyApp(),
    ),
  );
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
      home: BirdScreen(),
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
          if (state is BirdLoading) {
            return Center(child: CircularProgressIndicator());
          } else if (state is BirdError) {
            return Center(child: Text(state.message));
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
                        bird.breed,
                        style: TextStyle(fontWeight: FontWeight.bold),
                      ),
                      subtitle: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text('Owner: ${bird.owner}'),
                          Text('Handler: ${bird.handler}'),
                        ],
                      ),
                      leading: ClipOval(
                        child: SizedBox(
                          height: 50,
                          width: 50,
                          child: FadeInImage.assetNetwork(
                            placeholder: 'assets/placeholder.png',
                            image: 'http://localhost:8000/storage/images/${bird.image}',
                            fit: BoxFit.cover,
                            imageErrorBuilder: (context, error, stackTrace) {
                              return Container(
                                color: Colors.grey[200],
                                child: Icon(Icons.broken_image, color: Colors.grey[400]),
                              );
                            },
                          ),
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


