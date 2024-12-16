import 'package:flutter/material.dart';
import 'package:flutter_carousel_widget/flutter_carousel_widget.dart';

class BirdCarousel extends StatelessWidget {
  static const String baseUrl = 'http://127.0.0.1:8000/storage/images/';
  final List<dynamic> birds;

  const BirdCarousel({Key? key, required this.birds}) : super(key: key);

  @override
  Widget build(BuildContext context) {
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
            items: birds.map((bird) => _buildCarouselItem(bird)).toList(),
            options: CarouselOptions(
              height: 200.0,
              showIndicator: true,
              slideIndicator: CircularSlideIndicator(),
              autoPlay: true,
              autoPlayInterval: const Duration(seconds: 3),
              enableInfiniteScroll: true,
              viewportFraction: 0.8,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildCarouselItem(dynamic bird) {
    return Container(
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(8),
      ),
      child: ClipRRect(
        borderRadius: BorderRadius.circular(8),
        child: Image.network(
          '$baseUrl${bird['image']}',
          fit: BoxFit.cover,
          headers: const {
            'Accept': '*/*',
          },
          errorBuilder: (context, error, stackTrace) {
            print('Error loading carousel image: $error');
            return Container(
              color: Colors.grey[300],
              child: const Icon(Icons.error_outline, color: Colors.red),
            );
          },
          loadingBuilder: (context, child, loadingProgress) {
            if (loadingProgress == null) return child;
            return Center(
              child: CircularProgressIndicator(
                value: loadingProgress.expectedTotalBytes != null
                    ? loadingProgress.cumulativeBytesLoaded / 
                      loadingProgress.expectedTotalBytes!
                    : null,
              ),
            );
          },
        ),
      ),
    );
  }
} 