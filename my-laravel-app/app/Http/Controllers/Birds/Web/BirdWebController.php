<?php

namespace App\Http\Controllers\Birds\Web;

use App\Application\Bird\RegisterBird;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class BirdWebController extends Controller
{
    private RegisterBird $registerBird;
    public function __construct(RegisterBird $registerBird)
    {
        $this->registerBird = $registerBird;
    }
    /**
     * View Products.
     * **/
    public function index()
    {
        $birds = $this->registerBird->findAll();
        return view('Pages.Bird.index', compact('data'));
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

        $imageName = $bird->getImage(); // Keep existing image by default

        if ($request->hasFile('image')) {
            // Delete old image if it exists and isn't default
            if ($imageName && $imageName !== 'default.jpg' && Storage::disk('public')->exists('images/' . $imageName)) {
                Storage::disk('public')->delete('images/' . $imageName);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . str_replace(' ', '_', $image->getClientOriginalName());
            
            // Store the new image
            try {
                Storage::disk('public')->putFileAs('images', $image, $imageName);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to upload image: ' . $e->getMessage());
            }
        }

        try {
            $this->registerBird->update(
                $id,
                $validated['breed'],
                $validated['owner'],
                $validated['handler'],
                $imageName,
                now()->toDateTimeString()
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update bird: ' . $e->getMessage());
        }

        return redirect()->route('dashboard')->with('success', 'Bird updated successfully');
    }
    public function addBird(Request $request)
    {
        $validated = $request->validate([
            'owner' => 'required|string',
            'handler' => 'required|string',
            'breed' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imageName = 'default.jpg';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . str_replace(' ', '_', $image->getClientOriginalName());
            Storage::disk('public')->putFileAs('images', $image, $imageName);
        }

        $this->registerBird->create(
            $request->owner,
            $request->handler,
            $imageName,
            $request->breed,
            now()->toDateTimeString(),
            now()->toDateTimeString()
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


}
