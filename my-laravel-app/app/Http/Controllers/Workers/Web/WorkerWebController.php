<?php

namespace App\Http\Controllers\Workers\Web;

use App\Http\Controllers\Controller;
use App\Application\Worker\RegisterWorker;
use Illuminate\Http\Request;

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
        // Validation and worker creation logic will be handled by the API controller
        return redirect()->back();
    }

    public function updateWorker(Request $request, $id)
    {
        // Validation and worker update logic will be handled by the API controller
        return redirect()->back();
    }
}
