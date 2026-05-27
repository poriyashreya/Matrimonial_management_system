<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $userId = Auth::id();
        if (!$userId)
            return response()->json(['success' => 'Login required'], 401);

        if ($request->skip == 1) {
            Rating::updateOrCreate(
                ['user_id' => $userId],
                ['skip' => 1, 'rating' => null, 'comment' => null]
            );
            return response()->json(['success' => 'You have skipped rating. Thank you!']);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:100',
        ]);

        Rating::updateOrCreate(
            ['user_id' => $userId],
            ['rating' => $request->rating, 'comment' => $request->comment, 'skip' => 0]
        );

        return response()->json(['success' => 'Thanks for your rating!']);
    }

    public function skip(Request $request)
    {
        $userId = Auth::id();

        if (!$userId) {
            return response()->json(['success' => 'Please login to skip rating.']);
        }

        if ($request->skip == 1) {
            Rating::updateOrCreate(
                ['user_id' => $userId],
                [
                    'skip' => 1,
                    'rating' => 0,
                    'comment' => null
                ]
            );
        }
        return response()->json(['success' => 'You have skipped rating. Thank you!']);
    }

}