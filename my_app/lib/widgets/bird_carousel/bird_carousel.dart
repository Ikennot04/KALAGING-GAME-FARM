import 'package:flutter/material.dart';
import 'package:flutter_carousel_widget/flutter_carousel_widget.dart';
import 'carousel_item.dart';

class BirdCarousel extends StatelessWidget {
  static const String baseUrl = 'http://127.0.0.1:8000/storage/images/';
  final List<dynamic> birds;

  const BirdCarousel({Key? key, required this.birds}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final List<Widget> carouselItems = birds.map((bird) => CarouselItem(
          bird: bird,
          baseUrl: baseUrl,
        )).toList();

    return Container(
      margin: EdgeInsets.symmetric(vertical: 20),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Padding(
            padding: const EdgeInsets.only(left: 16.0, bottom: 8.0),
            child: Text(
              'Featured Birds',
              style: TextStyle(
                fontSize: 20,
                fontWeight: FontWeight.bold,
                color: Colors.blue.shade800,
              ),
            ),
          ),
          FlutterCarousel(
            items: carouselItems,
            options: CarouselOptions(
              height: 300.0,
              showIndicator: true,
              enableInfiniteScroll: true,
              autoPlay: false,
              viewportFraction: 0.8,
              enlargeCenterPage: true,
            ),
          ),
        ],
      ),
    );
  }
} 