<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicDashboardController extends Controller
{
    public function index()
    {
        // You can pass dynamic data if needed
        return view('welcome');
    }
}
