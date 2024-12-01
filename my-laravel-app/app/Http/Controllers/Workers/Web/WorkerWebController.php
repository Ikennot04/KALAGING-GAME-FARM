<?php

namespace App\Http\Controllers\Workers\Web;

use App\Http\Controllers\Controller;
use App\Application\Worker\RegisterWorker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WorkerWebController extends Controller
{
    private RegisterWorker $registerWorker;

    public function __construct(RegisterWorker $registerWorker)
    {
        $this->registerWorker = $registerWorker;
    }

    public function showWorkerPage()
    {
        $workers = $this->registerWorker->findAll();
        return view('Pages.Worker.worker', compact('workers'));
    }

    public function addWorker(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'position' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '', $image->getClientOriginalName());
                Storage::disk('public')->putFileAs('images', $image, $imageName);
            }

            $this->registerWorker->create(
                $validated['name'],
                $validated['position'],
                $imageName ?? 'default.jpg',
                now()->toDateTimeString(),
                now()->toDateTimeString()
            );

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Worker added successfully'], 201);
            }

            return redirect()->back()->with('success', 'Worker added successfully');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
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
            $this->registerWorker->update(
                $id,
                $validated['name'],
                $validated['position'],
                $imageName,
                now()->toDateTimeString()
            );

            return response()->json([
                'message' => 'Worker updated successfully',
                'image' => $imageName
            ], 200);
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
    public function softDelete(string $id): void
{
        WorkerModel::where('id', $id)
        ->update(['deleted' => 1]);
}

public function restore(string $id): void
{
    WorkerModel::where('id', $id)
        ->update(['deleted' => 0]);
}

public function findAllDeleted(): array
{
    $deletedWorkers = WorkerModel::deleted()->get();
    return $deletedWorkers->map(fn($model) => $this->createWorkerFromModel($model))->all();
}

public function findAll(): array
{
    // Only return non-deleted birds
    $workers = WorkerModel::active()->get();
        return $workers->map(fn($model) => $this->createWorkerFromModel($model))->all();
    }

    public function softDeleteWorker($id)
    {
        try {
            $this->registerWorker->softDelete($id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete worker'], 500);
        }
    }

    public function viewArchive()
    {
        $archivedWorkers = $this->registerWorker->findAllDeleted();
        return view('Pages.Archive.worker-archive', ['workers' => $archivedWorkers]);
    }

    public function restoreWorker($id)
    {
        try {
            $this->registerWorker->restore($id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to restore worker'], 500);
        }
    }
}
