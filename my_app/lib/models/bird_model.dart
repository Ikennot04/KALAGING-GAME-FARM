import 'package:equatable/equatable.dart';
import 'package:flutter/material.dart';

class Bird extends Equatable {
  final int id;
  final String description;
  final String owner;
  final String handler;
  final String breed;
  final String image;
  final String createdAt;

  const Bird({
    required this.id,
    required this.description,
    required this.owner,
    required this.handler,
    required this.breed,
    required this.image,
    required this.createdAt,
  });

  @override
  List<Object?> get props => [id, description, owner, handler, breed, image, createdAt];

  factory Bird.fromJson(Map<String, dynamic> json) {
    return Bird(
      id: json['id'] as int,
      description: json['description'] ?? '',
      owner: json['owner'] as String,
      handler: json['handler'] as String,
      breed: json['breed'] as String,
      image: json['image'] as String,
      createdAt: json['created_at'] as String,
    );
  }
}