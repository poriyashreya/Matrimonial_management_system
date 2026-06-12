<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    // SUBMIT RATING
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:255',
        ]);

        Rating::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
                'skip' => 0,
                'status' => 'rated'
            ]
        );

        return response()->json([
            'message' => 'Thanks for your rating!'
        ]);
    }

    // SKIP BUTTON
    public function skip()
    {
        
        $rating = Rating::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'rating' => 0,
                'comment' => null,
                'skip' => 1,
                'status' => 'skipped'
            ]
        );

        \Log::info($rating);

        return response()->json([
            'message' => 'You skipped rating.'
        ]);
    }

    // CANCEL / CLOSE POPUP
    public function cancel()
    {
        Rating::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'rating' => 0,
                'comment' => null,
                'skip' => 0,
                'status' => 'cancelled'
            ]
        );

        return response()->json([
            'message' => 'Popup closed.'
        ]);
    }
}