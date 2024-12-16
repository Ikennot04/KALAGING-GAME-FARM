import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../bloc/workers_bloc.dart';
import '../../bloc/workers_event.dart';
import '../../bloc/workers_state.dart';
import '../../models/worker_model.dart';

class WorkersList extends StatelessWidget {
  static const String baseUrl = 'http://127.0.0.1:8000/storage/images/';

  final TextEditingController _searchController = TextEditingController();

  Widget _buildSearchBar(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(16.0),
      child: TextField(
        controller: _searchController,
        decoration: InputDecoration(
          hintText: 'Search workers...',
          prefixIcon: Icon(Icons.search),
          border: OutlineInputBorder(
            borderRadius: BorderRadius.circular(12),
            borderSide: BorderSide(color: Colors.blue.shade200),
          ),
          filled: true,
          fillColor: Colors.white,
        ),
        onChanged: (value) {
          context.read<WorkerBloc>().add(SearchWorkersEvent(value));
        },
      ),
    );
  }

  Widget _buildImage(String imageUrl, String position) {
    return Stack(
      children: [
        Container(
          decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(12),
            image: DecorationImage(
              image: NetworkImage(imageUrl),
              fit: BoxFit.cover,
            ),
          ),
          height: 220,
          width: double.infinity,
        ),
        Positioned(
          bottom: 12,
          left: 12,
          right: 12,
          child: Text(
            position,
            style: TextStyle(
              color: Colors.white,
              fontSize: 16,
              fontWeight: FontWeight.bold,
            ),
          ),
        ),
      ],
    );
  }

  @override
  Widget build(BuildContext context) {
    return BlocBuilder<WorkerBloc, WorkerState>(
      builder: (context, state) {
        if (state is WorkerLoadingState) {
          return Center(child: CircularProgressIndicator());
        } else if (state is WorkerLoadedState) {
          return Column(
            children: [
              _buildSearchBar(context),
              Expanded(
                child: _buildWorkerList(context, state.workers),
              ),
            ],
          );
        } else if (state is WorkerErrorState) {
          return Center(
            child: Text(
              'Error: ${state.error}',
              style: TextStyle(color: Colors.red),
            ),
          );
        }
        return Center(child: Text('No data available'));
      },
    );
  }

  Widget _buildWorkerList(BuildContext context, List<dynamic> workers) {
    return ListView.builder(
      itemCount: workers.length,
      itemBuilder: (context, index) {
        final dynamic workerData = workers[index];
        final Worker worker = workerData is Worker 
            ? workerData 
            : Worker.fromJson(workerData as Map<String, dynamic>);

        final imageUrl = worker.image.isNotEmpty 
            ? '$baseUrl${worker.image}'
            : '${baseUrl}default.jpg';

        return Padding(
          padding: const EdgeInsets.all(16.0),
          child: GestureDetector(
            onTap: () {
              Navigator.pushNamed(
                context,
                '/worker-details',
                arguments: {'workerId': worker.id},
              );
            },
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                _buildImage(imageUrl, worker.position),
                SizedBox(height: 8),
                Text(
                  worker.name,
                  style: TextStyle(
                    fontSize: 18,
                    fontWeight: FontWeight.bold,
                  ),
                ),
              ],
            ),
          ),
        );
      },
    );
  }
}
