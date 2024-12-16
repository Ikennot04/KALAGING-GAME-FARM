import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../bloc/workers_bloc.dart';
import '../../bloc/workers_event.dart';
import '../../bloc/workers_state.dart';
import '../../repositories/worker_repository.dart';

class WorkersPage extends StatelessWidget {
  const WorkersPage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return BlocProvider(
      create: (context) => WorkerBloc(WorkerRepository())..add(FetchWorkersEvent()),
      child: Scaffold(
        appBar: AppBar(
          title: const Text('Workers'),
        ),
        body: BlocBuilder<WorkerBloc, WorkerState>(
          builder: (context, state) {
            if (state is WorkerLoading) {
              return const Center(child: CircularProgressIndicator());
            } else if (state is WorkerLoaded) {
              final workers = state.workers;
              return ListView.builder(
                itemCount: workers.length,
                itemBuilder: (context, index) {
                  final worker = workers[index];
                  return Card(
                    margin: const EdgeInsets.all(8.0),
                    child: ListTile(
                      leading: worker.image.isNotEmpty
                          ? Image.network(
                              'http://127.0.0.1:8000/storage/images/${worker.image}',
                              width: 50,
                              height: 50,
                              fit: BoxFit.cover,
                              errorBuilder: (context, error, stackTrace) {
                                return const Icon(Icons.error);
                              },
                              loadingBuilder: (context, child, loadingProgress) {
                                if (loadingProgress == null) return child;
                                return const CircularProgressIndicator();
                              },
                            )
                          : const Icon(Icons.person),
                      title: Text(worker.name),
                      subtitle: Text(worker.position),
                    ),
                  );
                },
              );
            } else if (state is WorkerError) {
              return Center(child: Text('Error: ${state.message}'));
            } else {
              return const Center(child: Text('No workers found.'));
            }
          },
        ),
      ),
    );
  }
}
