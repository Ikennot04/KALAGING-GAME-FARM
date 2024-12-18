import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:fl_chart/fl_chart.dart';
import 'package:flutter_carousel_widget/flutter_carousel_widget.dart';
import 'package:my_app/bloc/dashboard_bloc.dart';
import 'package:my_app/bloc/dashboard_event.dart';
import 'package:my_app/bloc/dashboard_state.dart';
import 'dart:math' as math;
import '../../bloc/birds_bloc.dart';
import '../../bloc/birds_state.dart';
import '../../bloc/birds_event.dart';
import '../../widgets/bird_carousel/bird_carousel.dart';
import '../../widgets/cockfights/schedule_widget.dart';

class DashboardPage extends StatefulWidget {
  @override
  _DashboardPageState createState() => _DashboardPageState();
}

class _DashboardPageState extends State<DashboardPage> with SingleTickerProviderStateMixin {
  late TabController _tabController;

  @override
  void initState() {
    super.initState();
    _tabController = TabController(length: 3, vsync: this);
    context.read<DashboardBloc>().add(FetchDashboardStatsEvent());
    context.read<BirdBloc>().add(FetchBirdsEvent());

    _tabController.addListener(() {
      if (!_tabController.indexIsChanging) {
        setState(() {});
      }
    });
  }

  @override
  void dispose() {
    _tabController.dispose();
    super.dispose();
  }

  String _getDynamicHeaderTitle() {
    switch (_tabController.index) {
      case 0:
        return 'Statistics';
      case 1:
        return 'Birds';
      case 2:
        return 'Schedule';
      default:
        return 'Dashboard';
    }
  }

  String _getDynamicHeaderSubtitle() {
    switch (_tabController.index) {
      case 0:
        return 'Birds and handlers statistics.';
      case 1:
        return 'View featured birds.';
      case 2:
        return 'Upcoming schedules and events.';
      default:
        return 'Manage your dashboard efficiently.';
    }
  }

  Color _getDynamicHeaderColor() {
    switch (_tabController.index) {
      case 0:
        return Colors.blue.shade100;
      case 1:
        return Colors.green.shade100;
      case 2:
        return Colors.orange.shade100;
      default:
        return Colors.grey.shade200;
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: BlocBuilder<DashboardBloc, DashboardState>(
        builder: (context, state) {
          if (state is DashboardLoading) {
            return Center(child: CircularProgressIndicator());
          } else if (state is DashboardLoaded) {
            return _buildDashboardContent(context, state);
          } else if (state is DashboardError) {
            return Center(child: Text('Error: ${state.message}'));
          }
          return Center(child: Text('No data available'));
        },
      ),
    );
  }

  Widget _buildDashboardContent(BuildContext context, DashboardLoaded state) {
    final List<Widget> dashboardItems = [
      _buildStatsSection(state),
      BlocBuilder<BirdBloc, BirdState>(
        builder: (context, state) {
          if (state is BirdLoadedState) {
            return BirdCarousel(birds: state.birds);
          }
          return SizedBox.shrink();
        },
      ),
      ScheduleWidget(),
    ];

    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        _buildHeader(),
        Expanded(
          child: FlutterCarousel(
            items: dashboardItems,
            options: CarouselOptions(
              height: MediaQuery.of(context).size.height * 0.8,
              viewportFraction: 0.95,
              enableInfiniteScroll: true,
              autoPlay: false,
              enlargeCenterPage: true,
              pageSnapping: true,
              onPageChanged: (index, reason) {
                _tabController.animateTo(index);
              },
            ),
          ),
        ),
      ],
    );
  }

  Widget _buildHeader() {
    return AnimatedContainer(
      duration: Duration(milliseconds: 300),
      color: _getDynamicHeaderColor(),
      padding: const EdgeInsets.symmetric(vertical: 16.0, horizontal: 24.0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              Text(
                _getDynamicHeaderTitle(),
                style: TextStyle(
                  fontSize: 28,
                  fontWeight: FontWeight.bold,
                  color: Colors.blueGrey.shade900,
                ),
              ),
              SizedBox(width: 12),
              // Swipe indicator dots
              Container(
                padding: EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                decoration: BoxDecoration(
                  color: Colors.white.withOpacity(0.3),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: List.generate(3, (index) => Container(
                    width: 6,
                    height: 6,
                    margin: EdgeInsets.symmetric(horizontal: 2),
                    decoration: BoxDecoration(
                      color: _tabController.index == index 
                          ? Colors.blueGrey.shade900 
                          : Colors.blueGrey.shade400,
                      shape: BoxShape.circle,
                    ),
                  )),
                ),
              ),
            ],
          ),
          SizedBox(height: 8),
          Text(
            _getDynamicHeaderSubtitle(),
            style: TextStyle(
              fontSize: 16,
              color: Colors.grey.shade700,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildStatsSection(DashboardLoaded state) {
    return SingleChildScrollView(
      child: Column(
        children: [
          Padding(
            padding: const EdgeInsets.all(16.0),
            child: Text(
              'Statistics Overview',
              style: TextStyle(
                fontSize: 20,
                fontWeight: FontWeight.bold,
                color: Colors.blueGrey.shade900,
              ),
            ),
          ),
          SizedBox(height: 12),
          Container(
            width: 300,
            height: 300,
            padding: EdgeInsets.all(16),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(16),
              boxShadow: [
                BoxShadow(
                  color: Colors.grey.withOpacity(0.1),
                  spreadRadius: 4,
                  blurRadius: 12,
                  offset: Offset(0, 4),
                ),
              ],
            ),
            child: BarChart(
              BarChartData(
                alignment: BarChartAlignment.spaceEvenly,
                maxY: _calculateMaxY(state.birdCount, state.workerCount),
                titlesData: FlTitlesData(
                  show: true,
                  bottomTitles: AxisTitles(
                    sideTitles: SideTitles(
                      showTitles: true,
                      getTitlesWidget: (value, meta) {
                        return Padding(
                          padding: const EdgeInsets.only(top: 8.0),
                          child: Text(
                            value == 0 ? 'Birds' : 'Handlers',
                            style: TextStyle(
                              color: Colors.grey.shade700,
                              fontWeight: FontWeight.bold,
                              fontSize: 14,
                            ),
                          ),
                        );
                      },
                    ),
                  ),
                  leftTitles: AxisTitles(
                    sideTitles: SideTitles(
                      showTitles: true,
                      reservedSize: 32,
                      interval: _calculateInterval(state.birdCount, state.workerCount),
                      getTitlesWidget: (value, meta) {
                        return Text(
                          value.toInt().toString(),
                          style: TextStyle(
                            color: Colors.grey.shade600,
                            fontSize: 12,
                          ),
                        );
                      },
                    ),
                  ),
                  topTitles: AxisTitles(
                    sideTitles: SideTitles(showTitles: false),
                  ),
                  rightTitles: AxisTitles(
                    sideTitles: SideTitles(showTitles: false),
                  ),
                ),
                gridData: FlGridData(
                  show: true,
                  drawHorizontalLine: true,
                  horizontalInterval: _calculateInterval(state.birdCount, state.workerCount),
                  getDrawingHorizontalLine: (value) => FlLine(
                    color: Colors.grey.shade300,
                    strokeWidth: 1,
                  ),
                ),
                borderData: FlBorderData(show: false),
                barGroups: [
                  BarChartGroupData(
                    x: 0,
                    barRods: [
                      BarChartRodData(
                        toY: state.birdCount.toDouble(),
                        color: Colors.blueAccent.withOpacity(0.7),
                        width: 30,
                        borderRadius: BorderRadius.circular(4),
                      ),
                    ],
                  ),
                  BarChartGroupData(
                    x: 1,
                    barRods: [
                      BarChartRodData(
                        toY: state.workerCount.toDouble(),
                        color: Colors.greenAccent.withOpacity(0.7),
                        width: 30,
                        borderRadius: BorderRadius.circular(4),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ),
          SizedBox(height: 24),
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceEvenly,
            children: [
              _DashboardStatCard(
                title: 'Birds',
                count: state.birdCount,
                color: Colors.blueAccent,
              ),
              _DashboardStatCard(
                title: 'Handlers',
                count: state.workerCount,
                color: Colors.greenAccent,
              ),
            ],
          ),
        ],
      ),
    );
  }

  double _calculateMaxY(int birdCount, int workerCount) {
    final maxCount = math.max(birdCount, workerCount);
    return (maxCount * 1.2).ceilToDouble();
  }

  double _calculateInterval(int birdCount, int workerCount) {
    final maxCount = math.max(birdCount, workerCount);
    if (maxCount <= 5) return 1;
    if (maxCount <= 10) return 2;
    if (maxCount <= 20) return 4;
    return (maxCount / 5).ceilToDouble();
  }
}

class _DashboardStatCard extends StatelessWidget {
  final String title;
  final int count;
  final Color color;

  const _DashboardStatCard({
    required this.title,
    required this.count,
    required this.color,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      width: 150,
      padding: EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.1),
            spreadRadius: 4,
            blurRadius: 12,
            offset: Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          Text(
            title,
            style: TextStyle(
              fontSize: 16,
              fontWeight: FontWeight.bold,
              color: Colors.grey.shade700,
            ),
          ),
          SizedBox(height: 8),
          Text(
            count.toString(),
            style: TextStyle(
              fontSize: 24,
              fontWeight: FontWeight.bold,
              color: color,
            ),
          ),
        ],
      ),
    );
  }
}
