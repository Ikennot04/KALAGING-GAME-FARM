import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../bloc/workers_bloc.dart';
import '../../bloc/workers_event.dart';
import '../../widgets/workerlist/workers_list.dart';

class WorkersPage extends StatefulWidget {
  @override
  _WorkersPageState createState() => _WorkersPageState();
}

class _WorkersPageState extends State<WorkersPage> {
  @override
  void initState() {
    super.initState();
    context.read<WorkerBloc>().add(FetchWorkersEvent());
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Workers List'),
      ),
      body: WorkersList(),
    );
  }
}