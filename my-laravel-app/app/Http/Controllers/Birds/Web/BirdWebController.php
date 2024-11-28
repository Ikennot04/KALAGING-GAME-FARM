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
    public function viewBirdPage()
{
    $birds = app(RegisterBird::class)->findAll(); // Returns array of Bird objects
    return view('Pages.Birds.bird', ['birds' => $birds]);
}
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

        $imageName = $bird->getImage();

        if ($request->hasFile('image')) {
            if ($imageName && $imageName !== 'default.jpg') {
                Storage::disk('public')->delete('images/' . $imageName);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . str_replace(' ', '_', $image->getClientOriginalName());
            Storage::disk('public')->putFileAs('images', $image, $imageName);
        }

        try {
            $this->registerBird->update(
                $id,
                $validated['owner'],
                $validated['handler'],
                $imageName,
                $validated['breed'],
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

    
    public function search(Request $request)
    {
        $searchTerm = $request->query('search', '');
        \Log::debug('Search request received', ['term' => $searchTerm]);

        try {
            $results = $this->registerBird->search($searchTerm);
            \Log::debug('Search results', [
                'match' => $results['match'] ? $results['match']->getId() : null,
                'related_count' => count($results['related'])
            ]);
            
            return response()->json([
                'match' => $results['match'] ? [
                    'id' => $results['match']->getId(),
                    'breed' => $results['match']->getBreed(),
                    'owner' => $results['match']->getOwner(),
                    'handler' => $results['match']->getHandler(),
                    'image' => $results['match']->getImage(),
                    'created_at' => $results['match']->Created(),
                    'updated_at' => $results['match']->Updated()
                ] : null,
                'related' => array_map(function($bird) {
                    return [
                        'id' => $bird->getId(),
                        'breed' => $bird->getBreed(),
                        'owner' => $bird->getOwner(),
                        'handler' => $bird->getHandler(),
                        'image' => $bird->getImage(),
                        'created_at' => $bird->Created(),
                        'updated_at' => $bird->Updated()
                    ];
                }, $results['related'])
            ]);
        } catch (\Exception $e) {
            \Log::error('Search failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error' => 'Search failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
