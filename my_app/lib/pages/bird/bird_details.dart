import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../bloc/birds_bloc.dart';
import '../../bloc/birds_state.dart';
import '../../bloc/birds_event.dart';

class BirdDetailsPage extends StatefulWidget {
  final int birdId;
  static const String baseUrl = 'http://127.0.0.1:8000/storage/images/';

  const BirdDetailsPage({Key? key, required this.birdId}) : super(key: key);

  @override
  State<BirdDetailsPage> createState() => _BirdDetailsPageState();
}

class _BirdDetailsPageState extends State<BirdDetailsPage> {
  @override
  void initState() {
    super.initState();
    context.read<BirdBloc>().add(FetchBirdsEvent());
  }

  @override
  Widget build(BuildContext context) {
    return BlocBuilder<BirdBloc, BirdState>(
      builder: (context, state) {
        if (state is BirdLoadingState) {
          return Scaffold(
            appBar: AppBar(title: Text('Bird Details')),
            body: Center(child: CircularProgressIndicator()),
          );
        }
        
        if (state is BirdLoadedState) {
          final bird = state.birds.firstWhere(
            (bird) => bird['id'] == widget.birdId,
            orElse: () => null,
          );

          if (bird == null) {
            return Scaffold(
              appBar: AppBar(title: Text('Bird Details')),
              body: Center(child: Text('Bird not found')),
            );
          }

          return Scaffold(
            appBar: AppBar(
              title: Text(bird['breed']),
              leading: IconButton(
                icon: Icon(Icons.arrow_back),
                onPressed: () => Navigator.of(context).pop(),
              ),
            ),
            body: SingleChildScrollView(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Hero(
                    tag: 'bird-${bird['id']}',
                    child: Image.network(
                      '${BirdDetailsPage.baseUrl}${bird['image']}',
                      width: double.infinity,
                      height: 300,
                      fit: BoxFit.cover,
                    ),
                  ),
                  Padding(
                    padding: const EdgeInsets.all(16.0),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          'Breed: ${bird['breed']}',
                          style: TextStyle(
                            fontSize: 24,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                        SizedBox(height: 16),
                        _buildInfoRow('Owner', bird['owner']),
                        _buildInfoRow('Handler', bird['handler']),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          );
        }

        return Scaffold(
          appBar: AppBar(title: Text('Bird Details')),
          body: Center(child: Text('Something went wrong')),
        );
      },
    );
  }

  Widget _buildInfoRow(String label, String value) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8.0),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            '$label: ',
            style: TextStyle(
              fontWeight: FontWeight.bold,
              fontSize: 16,
            ),
          ),
          Expanded(
            child: Text(
              value,
              style: TextStyle(fontSize: 16),
            ),
          ),
        ],
      ),
    );
  }
} 