import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:fl_chart/fl_chart.dart';
import 'package:my_app/bloc/dashboard_bloc.dart';
import 'package:my_app/bloc/dashboard_event.dart';
import 'package:my_app/bloc/dashboard_state.dart';
import 'dart:math' as math;
import '../../bloc/birds_bloc.dart';
import '../../bloc/birds_state.dart';
import '../../bloc/birds_event.dart';
import '../../widgets/bird_carousel/bird_carousel.dart';

class DashboardPage extends StatefulWidget {
  @override
  _DashboardPageState createState() => _DashboardPageState();
}

class _DashboardPageState extends State<DashboardPage> {
  @override
  void initState() {
    super.initState();
    context.read<DashboardBloc>().add(FetchDashboardStatsEvent());
    context.read<BirdBloc>().add(FetchBirdsEvent());
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
    return SingleChildScrollView(
      child: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              'Dashboard Overview',
              style: TextStyle(
                fontSize: 26,
                fontWeight: FontWeight.bold,
                color: Colors.blue.shade800
              )
            ),
            SizedBox(height: 16),
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
                    offset: Offset(0, 4)
                  )
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
                                fontSize: 14
                              )
                            )
                          );
                        }
                      )
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
                              fontSize: 12
                            )
                          );
                        }
                      )
                    ),
                    topTitles: AxisTitles(
                      sideTitles: SideTitles(showTitles: false)
                    ),
                    rightTitles: AxisTitles(
                      sideTitles: SideTitles(showTitles: false)
                    ),
                  ),
                  gridData: FlGridData(
                    show: true,
                    drawHorizontalLine: true,
                    horizontalInterval: _calculateInterval(state.birdCount, state.workerCount),
                    getDrawingHorizontalLine: (value) => 
                      FlLine(color: Colors.grey.shade300, strokeWidth: 1)
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
                          borderRadius: BorderRadius.circular(4)
                        )
                      ]
                    ),
                    BarChartGroupData(
                      x: 1,
                      barRods: [
                        BarChartRodData(
                          toY: state.workerCount.toDouble(),
                          color: Colors.greenAccent.withOpacity(0.7),
                          width: 30,
                          borderRadius: BorderRadius.circular(4)
                        )
                      ]
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
                  color: Colors.blueAccent
                ),
                _DashboardStatCard(
                  title: 'Handlers',
                  count: state.workerCount,
                  color: Colors.greenAccent
                ),
              ],
            ),
            SizedBox(height: 24),
            BlocBuilder<BirdBloc, BirdState>(
              builder: (context, state) {
                if (state is BirdLoadedState) {
                  return BirdCarousel(birds: state.birds);
                }
                return SizedBox.shrink();
              },
            ),
          ],
        ),
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
          )
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
