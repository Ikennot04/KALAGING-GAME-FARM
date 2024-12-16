class Worker {
  final int id;
  final String name;
  final String position;
  final String image;

  Worker({
    required this.id,
    required this.name,
    required this.position,
    required this.image,
  });

  factory Worker.fromJson(Map<String, dynamic> json) {
    return Worker(
      id: json['id'],
      name: json['name'],
      position: json['position'],
      image: json['image'],
    );
  }
}
