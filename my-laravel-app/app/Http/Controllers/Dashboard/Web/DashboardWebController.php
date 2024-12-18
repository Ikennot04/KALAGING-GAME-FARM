<?php

namespace App\Http\Controllers\Dashboard\Web;

use App\Application\Bird\RegisterBird;
use App\Application\Worker\RegisterWorker;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Infrastructure\Bird\BirdModel;
use App\Infrastructure\Worker\WorkerModel;
use App\Infrastructure\Bird\Bird;
use App\Infrastructure\Worker\Worker;
class DashboardWebController extends Controller
{
    private $registerBird;
    private $registerWorker;
    public function __construct(RegisterBird $registerBird, RegisterWorker $registerWorker)
    {
        $this->registerBird = $registerBird;
        $this->registerWorker = $registerWorker;
    }

    public function home()
    {
        $birdCount = $this->getBirdCount();
        $workerCount = $this->getWorkerCount();
        $handlerStats = $this->registerWorker->getHandlerStats();
        
        return view('Pages.Home.home', compact('handlerStats', 'workerCount', 'birdCount'));
    }

    public function getBirdCount(): int
    {
        $birds = $this->registerBird->findAll();
        return count($birds);
    }
    public function getWorkerCount(): int
    {
        $workers = $this->registerWorker->findAll();
        return count($workers);
    }

    public function getDashboardStats()
{
    $birdCount = count($this->registerBird->findAll());
    $workerCount = count($this->registerWorker->findAll());

    return response()->json([
        'birdCount' => $birdCount,
        'workerCount' => $workerCount
    ], 200);
    }

        
     
    
}
