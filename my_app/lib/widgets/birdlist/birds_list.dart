import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../bloc/birds_bloc.dart';
import '../../bloc/birds_state.dart';


class BirdsList extends StatelessWidget {
  static const String baseUrl = 'http://127.0.0.1:8000/storage/images/';

  Widget _buildImage(String imageUrl, String handler) {
    return Stack(
      children: [
        // Full-size image
        Container(
          decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(12),
            image: DecorationImage(
              image: NetworkImage(imageUrl),
              fit: BoxFit.cover, // Cover full area with no white spaces
            ),
          ),
          height: 200, // Set a fixed height for full-sized image
          width: double.infinity, // Make the image stretch full width
        ),
        // Handler overlay at the bottom
        Positioned(
          bottom: 0,
          left: 0,
          right: 0,
          child: Container(
            padding: EdgeInsets.symmetric(vertical: 8, horizontal: 12),
            color: Colors.black.withOpacity(0.6), // Semi-transparent overlay
            child: Text(
              'Handler: $handler',
              style: TextStyle(
                color: Colors.white,
                fontSize: 16,
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
    return BlocBuilder<BirdBloc, BirdState>(
      builder: (context, state) {
        if (state is BirdLoadingState) {
          return Center(child: CircularProgressIndicator());
        } else if (state is BirdLoadedState) {
          final birds = state.birds;
          return _buildBirdList(context, birds);
        } else if (state is BirdErrorState) {
          return Center(
            child: Text(
              'Error: ${state.error}',
              style: TextStyle(color: Colors.red),
            ),
          );
        } else {
          return Center(child: Text('No data available.'));
        }
      },
    );
  }

  Widget _buildBirdList(BuildContext context, List<dynamic> birds) {
    return ListView.builder(
      itemCount: birds.length,
      itemBuilder: (context, index) {
        final bird = birds[index];
        final imageUrl = '$baseUrl${bird['image']}';
        final handler = bird['handler'];

        return GestureDetector(
          onTap: () {
            Navigator.pushNamed(
              context,
              '/bird-details',
              arguments: {'birdId': bird['id']},
            );
          },
          child: Hero(
            tag: 'bird-${bird['id']}',
            child: Card(
              margin: EdgeInsets.symmetric(vertical: 8, horizontal: 16),
              elevation: 4,
              clipBehavior: Clip.antiAlias,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(12),
              ),
              child: _buildImage(imageUrl, handler),
            ),
          ),
        );
      },
    );
  }
}
