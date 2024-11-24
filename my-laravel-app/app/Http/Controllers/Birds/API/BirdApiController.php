<?php

namespace App\Http\Controllers\Birds\Api;

use App\Http\Controllers\Controller;
use App\Application\Bird\RegisterBird;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;  

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
            'image' => 'nullable',
            'breed' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        // $id = $this->generateUniqueId();

        if ($request->file('image')) {
            // Get the image from the request
            $image = $request->file('image');
            $destinationPath = 'images';

            // Renaming the image with the time of upload
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);

            // the image name will be saved in the database
            $data['image'] = $imageName;
        } else {
            // Default image if no image is uploaded
            $data['image'] = 'default.jpg';
        }

        // Make sure that the service method createBird handles the saving correctly
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

    $imageName = $bird->getImage(); // Default to the existing image

    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($imageName && $imageName !== 'default.jpg' && Storage::disk('public')->exists('images/' . $imageName)) {
            Storage::disk('public')->delete('images/' . $imageName);
        }

        // Store the new image
        $image = $request->file('image');
        $imageName = time() . '_' . str_replace(' ', '_', $image->getClientOriginalName());
        Storage::disk('public')->putFileAs('images', $image, $imageName);
    }

    // Update bird data
    try {
        $this->registerBird->update(
            $id,
            $validated['breed'],
            $validated['owner'],
            $validated['handler'],
            $imageName, // Use the updated image name
            now()->toDateTimeString()
        );
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to update bird: ' . $e->getMessage());
    }

    return redirect()->route('dashboard')->with('success', 'Bird updated successfully');
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