import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../bloc/birds_bloc.dart';
import '../../bloc/birds_event.dart';

import '../../widgets/birdlist/birds_list.dart';

class BirdsPage extends StatefulWidget {
  @override
  _BirdsPageState createState() => _BirdsPageState();
}

class _BirdsPageState extends State<BirdsPage> {
  @override
  void initState() {
    super.initState();
    // Trigger the event to fetch birds once the page is loaded
    context.read<BirdBloc>().add(FetchBirdsEvent());
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Birds List'),
      ),
      body: BirdsList(),
    );
  }
}
