import 'package:flutter/material.dart';

class DrawerWidget extends StatelessWidget {
  final Function(int) onItemTapped;

  DrawerWidget({required this.onItemTapped});

  @override
  Widget build(BuildContext context) {
    return Drawer(
      child: ListView(
        padding: EdgeInsets.zero,
        children: <Widget>[
          DrawerHeader(
            decoration: BoxDecoration(
              color: Colors.blue,
            ),
            child: Text(
              'KALAGING GAME FARM',
              style: TextStyle(
                color: Colors.white,
                fontSize: 24,
              ),
            ),
          ),
          ListTile(
            leading: Icon(Icons.dashboard),
            title: Text('Dashboard'),
            onTap: () {
              onItemTapped(0);
              Navigator.pop(context);
            },
          ),
          ListTile(
            leading: Icon(Icons.flutter_dash),
            title: Text('Birds'),
            onTap: () {
              onItemTapped(1);
              Navigator.pop(context);
            },
          ),
          ListTile(
            leading: Icon(Icons.people),
            title: Text('Handlers'),
            onTap: () {
              onItemTapped(2);
              Navigator.pop(context);
            },
          ),
        ],
      ),
    );
  }
}
