import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../bloc/workers_bloc.dart';
import '../../bloc/workers_state.dart';

class WorkersList extends StatelessWidget {
  static const String baseUrl = 'http://127.0.0.1:8000/storage/images/';

  // Builds image with a gradient overlay to improve text readability
  Widget _buildImage(String imageUrl, String position) {
    return Stack(
      children: [
        Container(
          decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(16),
            image: DecorationImage(
              image: NetworkImage(imageUrl),
              fit: BoxFit.cover,
            ),
          ),
          height: 250,
          width: double.infinity,
        ),
        Positioned(
          bottom: 0,
          left: 0,
          right: 0,
          child: Container(
            padding: EdgeInsets.symmetric(vertical: 12, horizontal: 16),
            decoration: BoxDecoration(
              gradient: LinearGradient(
                colors: [Colors.black.withOpacity(0.6), Colors.black.withOpacity(0)],
                begin: Alignment.bottomCenter,
                end: Alignment.topCenter,
              ),
              borderRadius: BorderRadius.vertical(bottom: Radius.circular(16)),
            ),
            child: Text(
              'Position: $position',
              style: TextStyle(
                color: Colors.white,
                fontSize: 18,
                fontWeight: FontWeight.bold,
              ),
              maxLines: 1,
              overflow: TextOverflow.ellipsis,
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
        if (state is WorkerLoading) {
          return Center(child: CircularProgressIndicator());
        } else if (state is WorkerLoaded) {
          return _buildWorkerList(context, state.workers);
        } else if (state is WorkerError) {
          return Center(child: Text('Error: ${state.message}'));
        }
        return Center(child: Text('No data available.'));
      },
    );
  }

  // Builds the worker list with cards that are more interactive and stylish
  Widget _buildWorkerList(BuildContext context, List<dynamic> workers) {
    return ListView.builder(
      itemCount: workers.length,
      itemBuilder: (context, index) {
        final worker = workers[index];
        final imageUrl = worker.image.isNotEmpty
            ? '$baseUrl${worker.image}'
            : '${baseUrl}default.jpg';

        return GestureDetector(
          onTap: () {
            Navigator.pushNamed(
              context,
              '/worker-details',
              arguments: {'workerId': worker.id},
            );
          },
          child: Hero(
            tag: 'worker-${worker.id}',
            child: Card(
              margin: EdgeInsets.symmetric(vertical: 12, horizontal: 16),
              elevation: 6,
              clipBehavior: Clip.antiAlias,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(16),
              ),
              child: _buildImage(imageUrl, worker.position),
            ),
          ),
        );
      },
    );
  }
}
