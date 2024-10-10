import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../bloc/bird_bloc.dart';
import '../bloc/bird_event.dart';
import '../bloc/bird_state.dart';
import '../models/bird_model.dart';

class BirdListScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    final birdNameController = TextEditingController();

    return Scaffold(
      appBar: AppBar(
        title: Text("Bird List"),
      ),
      body: Column(
        children: [
          TextField(
            controller: birdNameController,
            decoration: InputDecoration(labelText: 'Enter bird name'),
          ),
          ElevatedButton(
            onPressed: () {
              final bird = Bird(
                id: DateTime.now().toString(),
                name: birdNameController.text,
              );
              context.read<BirdBloc>().add(AddBird(bird));
            },
            child: Text('Add Bird'),
          ),
          Expanded(
            child: BlocBuilder<BirdBloc, BirdState>(
              builder: (context, state) {
                if (state is BirdLoadSuccess) {
                  return ListView.builder(
                    itemCount: state.birds.length,
                    itemBuilder: (context, index) {
                      final bird = state.birds[index];
                      return ListTile(
                        title: Text(bird.name),
                        trailing: IconButton(
                          icon: Icon(Icons.delete),
                          onPressed: () {
                            context.read<BirdBloc>().add(DeleteBird(bird.id));
                          },
                        ),
                      );
                    },
                  );
                }
                return const Center(child: Text("No birds found."));
              },
            ),
          ),
        ],
      ),
    );
  }
}
