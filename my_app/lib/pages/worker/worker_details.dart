import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../bloc/workers_bloc.dart';
import '../../bloc/workers_state.dart';
import '../../bloc/workers_event.dart';
import '../../models/worker_model.dart';

class WorkerDetailsPage extends StatefulWidget {
  final int workerId;
  static const String baseUrl = 'http://127.0.0.1:8000/storage/images/';

  const WorkerDetailsPage({Key? key, required this.workerId}) : super(key: key);

  @override
  State<WorkerDetailsPage> createState() => _WorkerDetailsPageState();
}

class _WorkerDetailsPageState extends State<WorkerDetailsPage> {
  @override
  void initState() {
    super.initState();
    context.read<WorkerBloc>().add(FetchWorkersEvent());
  }

  @override
  Widget build(BuildContext context) {
    return BlocBuilder<WorkerBloc, WorkerState>(
      builder: (context, state) {
        if (state is WorkerLoading) {
          return Scaffold(
            appBar: AppBar(title: Text('Worker Details')),
            body: Center(child: CircularProgressIndicator()),
          );
        }

        if (state is WorkerLoaded) {
          final worker = state.workers.firstWhere(
            (w) => w.id == widget.workerId,
            orElse: () => Worker(id: -1, name: '', position: '', image: ''),
          );

          if (worker.id == -1) {
            return Scaffold(
              appBar: AppBar(title: Text('Worker Details')),
              body: Center(child: Text('Worker not found')),
            );
          }

          return Scaffold(
            backgroundColor: Colors.grey.shade100,
            appBar: AppBar(
              title: Text('Handler Details'),
              leading: IconButton(
                icon: Icon(Icons.arrow_back, color: Colors.blue),
                onPressed: () => Navigator.of(context).pop(),
              ),
              backgroundColor: Colors.white,
              elevation: 0,
              centerTitle: true,
            ),
            body: SingleChildScrollView(
              child: Padding(
                padding: const EdgeInsets.all(16.0),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    // Worker Image
                    Center(
                      child: Hero(
                        tag: 'worker-${worker.id}',
                        child: ClipRRect(
                          borderRadius: BorderRadius.circular(12),
                          child: Image.network(
                            '${WorkerDetailsPage.baseUrl}${worker.image}',
                            width: double.infinity,
                            height: 250,
                            fit: BoxFit.cover,
                          ),
                        ),
                      ),
                    ),
                    SizedBox(height: 16),

                    // Static Information
                    Card(
                      elevation: 2,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                      child: Padding(
                        padding: const EdgeInsets.all(16.0),
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            _buildInfoRow('Name', worker.name),
                            _buildInfoRow('Position', worker.position),
                            _buildInfoRow('Joined', '12/16/2024'),
                            _buildInfoRow('Contact', 'handler@example.com'),
                            _buildInfoRow(
                                'Experience', '5 years handling championship chickens'),
                            _buildInfoRow(
                                'Specialty',
                                'Expert in combat training, nutrition management, and health monitoring'),
                          ],
                        ),
                      ),
                    ),
                    SizedBox(height: 16),

                    // Skills Section
                    Text(
                      'Skills',
                      style: TextStyle(
                        fontSize: 20,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                    SizedBox(height: 8),
                    _buildSkillsSection([
                      'Chicken health management',
                      'Combat training strategies',
                      'Nutritional planning',
                      'Record-keeping and reporting',
                    ]),
                    SizedBox(height: 16),

                    // Achievements Section
                    Text(
                      'Achievements',
                      style: TextStyle(
                        fontSize: 20,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                    SizedBox(height: 8),
                    _buildAchievementsSection([
                      {
                        'title': 'Best Handler 2023',
                        'description': 'Awarded for excellence in chicken care.',
                      },
                      {
                        'title': 'Top Trainer',
                        'description':
                            'Trained 15 championship-winning chickens.',
                      }
                    ]),
                  ],
                ),
              ),
            ),
          );
        }

        return Scaffold(
          appBar: AppBar(title: Text('Worker Details')),
          body: Center(child: Text('Something went wrong')),
        );
      },
    );
  }

  Widget _buildInfoRow(String label, String value) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 6.0),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
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

  Widget _buildSkillsSection(List<String> skills) {
    return Card(
      elevation: 1,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
      ),
      child: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: skills.map((skill) {
            return Padding(
              padding: const EdgeInsets.symmetric(vertical: 4.0),
              child: Row(
                children: [
                  Icon(Icons.check_circle, color: Colors.blue),
                  SizedBox(width: 8),
                  Expanded(
                    child: Text(
                      skill,
                      style: TextStyle(fontSize: 16, color: Colors.black87),
                    ),
                  ),
                ],
              ),
            );
          }).toList(),
        ),
      ),
    );
  }

  Widget _buildAchievementsSection(List<Map<String, String>> achievements) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: achievements.map((achievement) {
        return Expanded(
          child: Card(
            elevation: 2,
            color: Colors.green.shade50,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(12),
            ),
            margin: EdgeInsets.symmetric(horizontal: 8),
            child: Padding(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                children: [
                  Text(
                    achievement['title']!,
                    style: TextStyle(
                      fontWeight: FontWeight.bold,
                      fontSize: 16,
                      color: Colors.green,
                    ),
                  ),
                  SizedBox(height: 8),
                  Text(
                    achievement['description']!,
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      fontSize: 14,
                      color: Colors.black87,
                    ),
                  ),
                ],
              ),
            ),
          ),
        );
      }).toList(),
    );
  }
}
