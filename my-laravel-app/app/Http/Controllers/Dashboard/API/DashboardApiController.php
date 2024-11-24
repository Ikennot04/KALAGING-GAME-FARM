<?php

namespace App\Http\Controllers\Dashboard\API;

use App\Http\Controllers\Controller;
use App\Application\Bird\RegisterBird;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 

class DashboardApiController extends Controller
{
    private RegisterBird     $registerBird;

    public function __construct(RegisterBird $registerBird)
    {
        $this->registerBird = $registerBird;
    }

    public function getAll()
    {
        // Fetch all birds from the service
        $birdModels = $this->registerBird->findAll();
    
        // Convert each Bird object to an array using the toArray method
        $birds = array_map(fn($birdModel) => $birdModel->toArray(), $birdModels);
    
        // Return the data in a structured JSON response
        return response()->json(['birds' => $birds], 200);
    }

    public function search(Request $request)
{
    $searchTerm = $request->query('search', '');

    // Use the repository to perform the search
    $results = $this->registerBird->search($searchTerm);

    return response()->json([
        'match' => $results['match'] ? $results['match']->toArray() : null,
        'related' => $results['related']
    ]);
}
}
