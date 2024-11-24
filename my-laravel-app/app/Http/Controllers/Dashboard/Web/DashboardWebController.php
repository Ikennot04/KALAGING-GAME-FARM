<?php

namespace App\Http\Controllers\Dashboard\Web;

use App\Application\Bird\RegisterBird;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class DashboardWebController extends Controller
{
    public function viewDashboard()
{
    $birds = app(RegisterBird::class)->findAll(); // Returns array of Bird objects
    return view('Pages.Dashboard.index', ['birds' => $birds]);
}

    
}
