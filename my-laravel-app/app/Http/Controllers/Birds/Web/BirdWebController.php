<?php

namespace App\Http\Controllers\Birds\Web;

use App\Application\Bird\RegisterBird;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
