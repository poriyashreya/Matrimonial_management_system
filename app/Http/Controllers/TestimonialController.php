<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    // Frontend display
    public function index()
    {
        $rating_status = "nothing";
        return view('user.dashboard', compact('testimonials', 'rating_status'));
    }

    // Admin form
    public function create()
    {
        $profile = auth()->user()->profile;
        $rating_status = "nothing";
        return view('user.create_testimonial', compact('profile', 'rating_status'));
    }

    // Store testimonial
    public function store(Request $request)
    {
        $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'couple_name' => 'required|string|max:255',
            'status' => 'nullable|in:Married,Engaged',
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->image->store('testimonials', 'public');
        }

        Testimonial::create([
            'profile_id' => $request->profile_id,
            'couple_name' => $request->couple_name,
            'status' => $request->status,
            'message' => $request->message,
            'image' => $imagePath,
        ]);

        $rating_status = "nothing";

        return redirect()->route('user.dashboard')->with('success', 'Testimonial added successfully');
    }
}

