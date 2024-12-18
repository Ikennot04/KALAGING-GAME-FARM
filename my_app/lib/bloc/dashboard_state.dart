abstract class DashboardState {}

class DashboardInitial extends DashboardState {}

class DashboardLoading extends DashboardState {}

class DashboardLoaded extends DashboardState {
  final int birdCount;
  final int workerCount;

  DashboardLoaded({
    required this.birdCount,
    required this.workerCount,
  });
}

class DashboardError extends DashboardState {
  final String message;

  DashboardError(this.message);
}