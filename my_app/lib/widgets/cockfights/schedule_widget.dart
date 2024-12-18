import 'package:flutter/material.dart';
import 'package:intl/intl.dart';

class ScheduleWidget extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    final now = DateTime.now();
    final formatter = DateFormat('MMMM d, yyyy');

    // Dynamic dates
    final dates = [
      formatter.format(now.add(Duration(days: 7))),
      formatter.format(now.add(Duration(days: 14))),
      formatter.format(now.add(Duration(days: 30))),
      formatter.format(now.subtract(Duration(days: 10))),
      formatter.format(now.subtract(Duration(days: 30))),
    ];

    return SingleChildScrollView(
      child: Card(
        elevation: 8,
        margin: EdgeInsets.all(16),
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(16),
        ),
        child: Container(
          decoration: BoxDecoration(
            gradient: LinearGradient(
              colors: [Colors.blue.shade800, Colors.blue.shade600],
              begin: Alignment.topLeft,
              end: Alignment.bottomRight,
            ),
            borderRadius: BorderRadius.circular(16),
          ),
          child: Padding(
            padding: EdgeInsets.all(16),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                _buildSectionTitle('Upcoming Fights'),
                _buildScheduleItem(
                  context,
                  date: dates[0],
                  location: 'Kalaging Gamefarm Arena',
                  time: '3:00 PM',
                ),
                _buildScheduleItem(
                  context,
                  date: dates[1],
                  location: 'Mangkon Stadium',
                  time: '5:00 PM',
                ),
                SizedBox(height: 16),
                _buildSectionTitle('Padung nga Away'),
                _buildScheduleItem(
                  context,
                  date: dates[2],
                  location: 'Southern Cockpit',
                  time: '2:00 PM',
                ),
                SizedBox(height: 16),
                _buildSectionTitle('Past nga Away'),
                _buildScheduleItem(
                  context,
                  date: dates[3],
                  location: 'North Arena',
                  time: '4:00 PM',
                ),
                _buildScheduleItem(
                  context,
                  date: dates[4],
                  location: 'Central Dome',
                  time: '6:00 PM',
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildSectionTitle(String title) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8),
      child: Text(
        title,
        style: TextStyle(
          fontSize: 22,
          fontWeight: FontWeight.bold,
          color: Colors.white,
        ),
      ),
    );
  }

  Widget _buildScheduleItem(
    BuildContext context, {
    required String date,
    required String location,
    required String time,
  }) {
    return InkWell(
      onTap: () {
        _showDetailsDialog(context, date: date, location: location, time: time);
      },
      child: Container(
        padding: EdgeInsets.all(16),
        margin: EdgeInsets.symmetric(vertical: 6),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(12),
          boxShadow: [
            BoxShadow(
              color: Colors.black.withOpacity(0.1),
              spreadRadius: 2,
              blurRadius: 5,
              offset: Offset(0, 3),
            ),
          ],
        ),
        child: Row(
          children: [
            Icon(
              Icons.calendar_today,
              color: Colors.blue.shade800,
              size: 36,
            ),
            SizedBox(width: 16),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    date,
                    style: TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                      color: Colors.blue.shade800,
                    ),
                  ),
                  SizedBox(height: 8),
                  Text(
                    location,
                    style: TextStyle(
                      fontSize: 16,
                      color: Colors.grey.shade700,
                    ),
                  ),
                  Text(
                    time,
                    style: TextStyle(
                      fontSize: 16,
                      color: Colors.grey.shade600,
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  void _showDetailsDialog(BuildContext context, {required String date, required String location, required String time}) {
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return AlertDialog(
          title: Text('Fight Details'),
          content: Column(
            mainAxisSize: MainAxisSize.min,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text('Date: $date'),
              Text('Location: $location'),
              Text('Time: $time'),
            ],
          ),
          actions: [
            TextButton(
              onPressed: () {
                Navigator.of(context).pop();
              },
              child: Text('OK'),
            ),
          ],
        );
      },
    );
  }
}
