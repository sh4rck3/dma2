<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class LandingpageController extends Controller
{
    public function index()
    {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register')
        ]);
    }

    public function extensions()
    {
        return Inertia::render('Extension');
    }

    public function smssend()
    {
        return Inertia::render('Sms/Smssend');
    }

    public function birthday()
    {
        return Inertia::render('Birthday');
    }
}
