import 'package:flutter_bloc/flutter_bloc.dart';

import '../repositories/dashboard_repository.dart';
import 'dashboard_event.dart';
import 'dashboard_state.dart';

class DashboardBloc extends Bloc<DashboardEvent, DashboardState> {
  final DashboardRepository repository;

  DashboardBloc({required this.repository}) : super(DashboardInitial()) {
    on<FetchDashboardStatsEvent>((event, emit) async {
      emit(DashboardLoading());
      
      try {
        final stats = await repository.getDashboardStats();
        emit(DashboardLoaded(
          birdCount: stats['birdCount'],
          workerCount: stats['workerCount'],
        ));
      } catch (e) {
        emit(DashboardError(e.toString()));
      }
    });
  }
}