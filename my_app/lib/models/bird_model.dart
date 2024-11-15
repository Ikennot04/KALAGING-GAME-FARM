import 'package:equatable/equatable.dart';
import 'package:flutter/material.dart';

class  Bird extends Equatable {

  final String id;
  final String description;
  final String owner;
  final Image image;

  const Bird({
    required this.id,
    required this.description,
    required this.owner,
    required this.image,
  });

  @override
  List<Object?> get props => [id, description, owner, image];

  static List<Bird> birds = [
    Bird(
    id: '0',
    description: 'Kani',
    owner: 'Kentoy',
    image: Image.asset('assets/branch3.jpg'),
    ),
    Bird(
      id: '1', 
      description: 'Kani',
    owner: 'Kentoy',
      image: Image.asset('assets/MANGKOS.jpg'),
    ),
    
    
    
  ];

  
}