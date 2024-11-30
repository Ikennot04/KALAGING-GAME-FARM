<?php

namespace App\Http\Controllers\Workers\API;

use App\Http\Controllers\Controller;
use App\Application\Worker\RegisterWorker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class WorkerApiController extends Controller
{
    private RegisterWorker     $registerWorker;

    public function __construct(RegisterWorker $registerWorker)
    {
        $this->registerWorker = $registerWorker;
    }

    // Create a new bird
    public function addWorker(Request $request)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'name' => 'required|string',
            'position' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '', $image->getClientOriginalName());
            
            Storage::disk('public')->putFileAs('images', $image, $imageName);
            $data['image'] = $imageName;
        } else {
            $data['image'] = 'default.jpg';
        }

        $this->registerWorker->create(
            $request->name,
            $request->position,
            $data['image'],
            Carbon::now()->toDateTimeString(),
            Carbon::now()->toDateTimeString()
        );

        return response()->json(['message' => 'Worker created successfully'], 201);
    }

    /**
     * Validate the new ID (it must be unique in the table)
     */
        // private function generateUniqueId(): string
    // {
    //     do {
    //         $id = $this->generateRandomAlphanumericID(15);
    //     } while ($this->registerBird->findByBirdID($id));  // Assuming findByBirdID method exists

    //     return $id;
    // }

    /**
     * Generate random 15-character alphanumeric ID
     */
    private function generateRandomAlphanumericID(int $length = 15): string
    {
        return substr(bin2hex(random_bytes($length / 2)), 0, $length);
    }


    public function getAll()
{
    // Fetch all birds from the service
    $workerModels = $this->registerWorker->findAll();

    // Convert each Bird object to an array using the toArray method
    $workers = array_map(fn($workerModel) => $workerModel->toArray(), $workerModels);

    // Return the data in a structured JSON response
    return response()->json(['workers' => $workers], 200);
}

public function updateWorker($id, Request $request)
{
    $worker = $this->registerWorker->findByWorkerID($id);
    if (!$worker) {
        abort(404);
    }

    $validated = $request->validate([
        'name' => 'required|string',
        'position' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $imageName = $worker->getImage();

    if ($request->hasFile('image')) {
        if ($imageName && $imageName !== 'default.jpg') {
            Storage::disk('public')->delete('images/' . $imageName);
        }

        $image = $request->file('image');
        $imageName = time() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '', $image->getClientOriginalName());
        Storage::disk('public')->putFileAs('images', $image, $imageName);
    }

    try {
        // Match Bird constructor parameter order
        $this->registerWorker->update(
            $id,
            $validated['name'],    // name
            $validated['position'],  // position
            $imageName,            // image
            now()->toDateTimeString()
        );

        return response()->json(['message' => 'Worker updated successfully'], 200);
    } catch (\Exception $e) {
        Log::error('Failed to update worker: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to update worker: ' . $e->getMessage()], 500);
    }
}
public function search(Request $request)
{
    $searchTerm = $request->query('search', '');

    // Use the repository to perform the search
    $results = $this->registerWorker->search($searchTerm);

    return response()->json([
        'match' => $results['match'] ? [
            'id' => $results['match']->getId(),
            'name' => $results['match']->getName(),
            'position' => $results['match']->getPosition(),
            'image' => $results['match']->getImage(),
            'created_at' => $results['match']->getCreatedAt(),
            'updated_at' => $results['match']->getUpdatedAt()
        ] : null,
        'related' => array_map(function($worker) {
            return [
                'id' => $worker->getId(),
                'name' => $worker->getName(),
                'position' => $worker->getPosition(),
                'image' => $worker->getImage(),
                'created_at' => $worker->getCreatedAt(),
                'updated_at' => $worker->getUpdatedAt()
            ];
        }, $results['related'])
    ]);
}
public function getWorkerById($id)
{
    try {
        $workerId = (int) $id;
        
        if ($workerId <= 0) {
            return response()->json(['error' => 'Invalid worker ID'], 400);
        }

        $worker = $this->registerWorker->findByWorkerID($workerId);

        if (!$worker) {
            return response()->json(['error' => 'Worker not found'], 404);
        }

        $workerData = [
            'id' => $worker->getId(),
            'name' => $worker->getName(),
            'position' => $worker->getPosition(),
            'image' => $worker->getImage(),
            'created_at' => $worker->getCreatedAt()
        ];

        return response()->json($workerData);
    } catch (\Exception $e) {
        \Log::error('Failed to fetch worker details: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());
        
        return response()->json([
            'error' => 'Failed to fetch worker details',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
}
}
