import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../bloc/birds_bloc.dart';
import '../../bloc/birds_state.dart';
import '../../bloc/birds_event.dart';
import 'dart:html' as html;


class BirdsList extends StatelessWidget {
  static const String baseUrl = 'http://127.0.0.1:8000/storage/images/';
  final TextEditingController _searchController = TextEditingController();

  Widget _buildSearchBar(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(16.0),
      child: TextField(
        controller: _searchController,
        decoration: InputDecoration(
          hintText: 'Search birds...',
          prefixIcon: Icon(Icons.search),
          border: OutlineInputBorder(
            borderRadius: BorderRadius.circular(12),
            borderSide: BorderSide(color: Colors.blue.shade200),
          ),
          filled: true,
          fillColor: Colors.white,
        ),
        onChanged: (value) {
          context.read<BirdBloc>().add(SearchBirdsEvent(value));
        },
      ),
    );
  }

  Widget _buildImage(String imageUrl, String handler) {
    return Stack(
      children: [
        // Image container
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
        // Gradient overlay
        Positioned.fill(
          child: DecoratedBox(
            decoration: BoxDecoration(
              borderRadius: BorderRadius.circular(12),
              gradient: LinearGradient(
                begin: Alignment.topCenter,
                end: Alignment.bottomCenter,
                colors: [
                  Colors.transparent,
                  Colors.black.withOpacity(0.7),
                ],
                stops: const [0.6, 1.0],
              ),
            ),
          ),
        ),
        // Handler info
        Positioned(
          bottom: 12,
          left: 12,
          right: 12,
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Expanded(
                child: Text(
                  'Handler: $handler',
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: 16,
                    fontWeight: FontWeight.bold,
                    shadows: [
                      Shadow(
                        offset: Offset(0, 1),
                        blurRadius: 3,
                        color: Colors.black.withOpacity(0.5),
                      ),
                    ],
                  ),
                  maxLines: 1,
                  overflow: TextOverflow.ellipsis,
                ),
              ),
              IconButton(
                icon: Icon(Icons.email, color: Colors.white),
                onPressed: () {
                  final mailtoUrl = 'mailto:$handler@gmail.com?subject=Bird%20Inquiry';
                  html.window.open(mailtoUrl, '_blank');
                },
                tooltip: 'Contact Handler',
              ),
            ],
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
          return Column(
            children: [
              _buildSearchBar(context),
              Expanded(
                child: _buildBirdList(context, state.birds),
              ),
            ],
          );
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
