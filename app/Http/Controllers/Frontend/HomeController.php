<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Slide;

class HomeController extends Controller
{
        public function index()
    {
        $slides = Slide::active()->orderBy('position', 'ASC')->get();;
        return view('frontend.home', compact('slides'));
    }
}
