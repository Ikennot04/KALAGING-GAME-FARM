import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../bloc/birds_bloc.dart';
import '../../bloc/birds_state.dart';
import '../../bloc/birds_event.dart';
import 'dart:html' as html;

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
            backgroundColor: Colors.grey.shade100,
            appBar: AppBar(
              title: Text('Cockfighting Chicken Details'),
              backgroundColor: Colors.white,
              elevation: 0,
              centerTitle: true,
              leading: IconButton(
                icon: Icon(Icons.arrow_back, color: Colors.blue),
                onPressed: () => Navigator.of(context).pop(),
              ),
            ),
            body: SingleChildScrollView(
              child: Padding(
                padding: const EdgeInsets.all(16.0),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    // Image Section
                    Center(
                      child: ClipRRect(
                        borderRadius: BorderRadius.circular(12),
                        child: Image.network(
                          '${BirdDetailsPage.baseUrl}${bird['image']}',
                          width: double.infinity,
                          height: 250,
                          fit: BoxFit.cover,
                        ),
                      ),
                    ),
                    SizedBox(height: 16),

                    // Bird Details
                    Card(
                      elevation: 2,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                      child: Padding(
                        padding: const EdgeInsets.all(16.0),
                        child: Column(
                          children: [
                            _buildInfoRow('Breed', bird['breed']),
                            _buildInfoRow('Owner', bird['owner']),
                            _buildInfoRow('Handler', bird['handler']),
                            _buildInfoRow(
                              'Added to the farm', 
                              DateTime.parse(bird['created_at']).toLocal().toString().split(' ')[0]
                            ),
                            _buildClickableEmailRow('Email', '${bird['handler']}@gmail.com'),
                          ],
                        ),
                      ),
                    ),
                    SizedBox(height: 16),

                    // Fighting History
                    Text(
                      'Fighting History',
                      style: TextStyle(
                        fontSize: 20,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                    SizedBox(height: 8),
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                      children: [
                        _buildHistoryCard('Wins', '0', Colors.green.shade100),
                        _buildHistoryCard('Losses', '0', Colors.red.shade100),
                        _buildHistoryCard('Draws', '0', Colors.yellow.shade100),
                      ],
                    ),
                    SizedBox(height: 16),

                    // Fitness Level
                    Text(
                      'Fitness Level',
                      style: TextStyle(
                        fontSize: 20,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                    SizedBox(height: 8),
                    _buildStaticInfoCard('No fitness information available.'),

                    SizedBox(height: 16),

                    // Diet Information
                    Text(
                      'Diet Information',
                      style: TextStyle(
                        fontSize: 20,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                    SizedBox(height: 8),
                    _buildStaticInfoCard('No diet information available.'),
                  ],
                ),
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
      padding: const EdgeInsets.symmetric(vertical: 6.0),
      child: Row(
        children: [
          Text(
            '$label: ',
            style: TextStyle(
              fontWeight: FontWeight.bold,
              fontSize: 16,
              color: Colors.black87,
            ),
          ),
          Expanded(
            child: Text(
              value,
              style: TextStyle(fontSize: 16, color: Colors.black54),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildClickableEmailRow(String label, String email) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 6.0),
      child: Row(
        children: [
          Text(
            '$label: ',
            style: TextStyle(
              fontWeight: FontWeight.bold,
              fontSize: 16,
              color: Colors.black87,
            ),
          ),
          Expanded(
            child: GestureDetector(
              onTap: () {
                final mailtoUrl = 'mailto:$email?subject=Bird%20Inquiry';
                html.window.open(mailtoUrl, '_blank');
              },
              child: Text(
                email,
                style: TextStyle(
                  fontSize: 16,
                  color: Colors.blue,
                  decoration: TextDecoration.underline,
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildHistoryCard(String title, String value, Color color) {
    return Expanded(
      child: Card(
        elevation: 1,
        color: color,
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
        child: Padding(
          padding: const EdgeInsets.symmetric(vertical: 12),
          child: Column(
            children: [
              Text(
                title,
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 16,
                  color: Colors.black87,
                ),
              ),
              SizedBox(height: 8),
              Text(
                value,
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 18,
                  color: Colors.black,
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildStaticInfoCard(String info) {
    return Card(
      elevation: 1,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
      child: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Text(
          info,
          style: TextStyle(fontSize: 16, color: Colors.black54),
        ),
      ),
    );
  }
}
