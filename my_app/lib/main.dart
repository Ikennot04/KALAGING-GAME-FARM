import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'bloc/birds_bloc.dart';
import 'pages/bird/bird.dart';
import 'widgets/drawer/drawer_widget.dart';
import 'pages/dashboard/dashboard.dart';
import 'pages/workers/worker.dart';
import 'bloc/dashboard_bloc.dart';
import 'repositories/dashboard_repository.dart';
import 'routes/app_routes.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Sidebar Navigation',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        primarySwatch: Colors.blue,
      ),
      home: const MyHomePage(),
      routes: AppRoutes.routes,
    );
  }
}

class MyHomePage extends StatefulWidget {
  const MyHomePage({super.key});
  @override
  MyHomePageState createState() => MyHomePageState();
}

class MyHomePageState extends State<MyHomePage> {
  int _selectedIndex = 0;

  // Removed const here since we're using non-const constructors for the pages
  final List<Widget> _pages = <Widget>[
    MultiBlocProvider(
      providers: [
        BlocProvider(
          create: (context) => DashboardBloc(
            repository: DashboardRepository(),
          ),
        ),
        BlocProvider(
          create: (context) => BirdBloc(),
        ),
      ],
      child: DashboardPage(),
    ),
    BlocProvider(
      create: (context) => BirdBloc(),
      child: BirdsPage(),
    ),
    WorkersPage(),
  ];

  void _onItemTapped(int index) {
    setState(() {
      _selectedIndex = index;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(),
      drawer: DrawerWidget(onItemTapped: _onItemTapped),
      body: Center(
        child: _pages.elementAt(_selectedIndex),
      ),
    );
  }
}
