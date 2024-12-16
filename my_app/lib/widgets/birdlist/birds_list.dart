import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../bloc/birds_bloc.dart';
import '../../bloc/birds_state.dart';
import '../../bloc/birds_event.dart';

class BirdsList extends StatelessWidget {
  static const String baseUrl = 'http://127.0.0.1:8000/storage/images/';

  Widget _buildImage(String imageUrl) {
    return ClipRRect(
      borderRadius: BorderRadius.circular(12),
      child: Image.network(
        imageUrl,
        width: 70,
        height: 70,
        fit: BoxFit.cover,
        headers: {
          'Accept': 'image/*',
        },
        errorBuilder: (context, error, stackTrace) {
          print('Error loading image: $error');
          return Container(
            width: 70,
            height: 70,
            color: Colors.grey[300],
            child: Icon(Icons.error_outline, color: Colors.red),
          );
        },
        loadingBuilder: (context, child, loadingProgress) {
          if (loadingProgress == null) return child;
          return Container(
            width: 70,
            height: 70,
            color: Colors.grey[300],
            child: Center(
              child: CircularProgressIndicator(
                value: loadingProgress.expectedTotalBytes != null
                    ? loadingProgress.cumulativeBytesLoaded /
                        loadingProgress.expectedTotalBytes!
                    : null,
              ),
            ),
          );
        },
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return BlocBuilder<BirdBloc, BirdState>(
      builder: (context, state) {
        if (state is BirdLoadingState) {
          return _buildLoadingState(context);
        } else if (state is BirdLoadedState) {
          final birds = state.birds;
          return _buildBirdList(context, birds);
        } else if (state is BirdErrorState) {
          return _buildErrorState(context, state);
        } else {
          return Center(child: Text('No data available.'));
        }
      },
    );
  }

  Widget _buildLoadingState(BuildContext context) {
    return Center(
      child: CircularProgressIndicator(
        valueColor: AlwaysStoppedAnimation<Color>(Colors.blue),
      ),
    );
  }

  Widget _buildErrorState(BuildContext context, BirdErrorState state) {
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(
            Icons.error_outline,
            color: Colors.red,
            size: 50,
          ),
          SizedBox(height: 16),
          Text(
            'Oops! Something went wrong.',
            style: TextStyle(
              fontSize: 22,
              fontWeight: FontWeight.bold,
              color: Colors.red,
            ),
          ),
          SizedBox(height: 8),
          Text(
            state.error,
            style: TextStyle(
              fontSize: 16,
              color: Colors.red[700],
            ),
            textAlign: TextAlign.center,
          ),
          SizedBox(height: 24),
          ElevatedButton(
            onPressed: () {
              context.read<BirdBloc>().add(FetchBirdsEvent());
            },
            child: Text('Retry'),
          ),
        ],
      ),
    );
  }

  Widget _buildBirdList(BuildContext context, List<dynamic> birds) {
    return ListView.builder(
      itemCount: birds.length,
      itemBuilder: (context, index) {
        final bird = birds[index];
        final imageUrl = '$baseUrl${bird['image']}';

        return Card(
          margin: EdgeInsets.symmetric(vertical: 8, horizontal: 16),
          elevation: 4,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(15),
          ),
          child: ListTile(
            contentPadding: EdgeInsets.all(16),
            leading: _buildImage(imageUrl),
            title: Text(
              'Breed: ${bird['breed']}',
              style: TextStyle(
                fontSize: 18,
                fontWeight: FontWeight.w600,
                color: Colors.black87,
              ),
            ),
            subtitle: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                SizedBox(height: 8),
                Text('Owner: ${bird['owner']}'),
                SizedBox(height: 4),
                Text('Handler: ${bird['handler']}'),
              ],
            ),
          ),
        );
      },
    );
  }
}
