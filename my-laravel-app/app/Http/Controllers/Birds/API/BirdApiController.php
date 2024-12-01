<?php

namespace App\Http\Controllers\Birds\Api;

use App\Http\Controllers\Controller;
use App\Application\Bird\RegisterBird;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BirdApiController extends Controller
{
    private RegisterBird     $registerBird;

    public function __construct(RegisterBird $registerBird)
    {
        $this->registerBird = $registerBird;
    }

    // Create a new bird
    public function addBird(Request $request)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'owner' => 'required|string',
            'handler' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'breed' => 'required|string',
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

        $this->registerBird->create(
            $request->owner,
            $request->handler,
            $data['image'],
            $request->breed,
            Carbon::now()->toDateTimeString(),
            Carbon::now()->toDateTimeString()
        );

        return response()->json(['message' => 'Bird created successfully'], 201);
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
    $birdModels = $this->registerBird->findAll();

    // Convert each Bird object to an array using the toArray method
    $birds = array_map(fn($birdModel) => $birdModel->toArray(), $birdModels);

    // Return the data in a structured JSON response
    return response()->json(['birds' => $birds], 200);
}

public function updateBird($id, Request $request)
{
    $bird = $this->registerBird->findByBirdID($id);
    if (!$bird) {
        abort(404);
    }

    $validated = $request->validate([
        'breed' => 'required|string',
        'owner' => 'required|string',
        'handler' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $imageName = $bird->getImage();

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
        $this->registerBird->update(
            $id,
            $validated['owner'],    // owner
            $validated['handler'],  // handler
            $imageName,            // image
            $validated['breed'],    // breed
            now()->toDateTimeString()
        );

        return response()->json(['message' => 'Bird updated successfully'], 200);
    } catch (\Exception $e) {
        Log::error('Failed to update bird: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to update bird: ' . $e->getMessage()], 500);
    }
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

public function getBirdById($id)
{
    try {
        $birdId = (int) $id;
        $bird = $this->registerBird->findByBirdID($birdId);

        if (!$bird) {
            return response()->json(['error' => 'Bird not found'], 404);
        }

        // Convert bird object to array format
        $birdData = [
            'id' => $bird->getId(),
            'owner' => $bird->getOwner(),
            'image' => $bird->getImage(),
            'handler' => $bird->getHandler(),
            'breed' => $bird->getBreed(),
            'created_at' => $bird->Created()
        ];

        return response()->json($birdData);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Failed to fetch bird details',
            'message' => $e->getMessage()
        ], 500);
    }
}

}