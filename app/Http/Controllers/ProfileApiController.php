<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Image;
use App\Models\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ProfileApiController extends Controller
{
    // List all public profiles except current user and apply optional filters
    public function index()
    {
        $myProfile = Profile::where('user_id', Auth::id())->first();

        if (!$myProfile) {
            return response()->json(['message' => 'Create your profile first'], 404);
        }

        $profiles = Profile::with(['user', 'images'])
            ->where('visibility', 'public')
            ->where('user_id', '!=', Auth::id())
            ->where('gender', '!=', $myProfile->gender)
            ->where('is_active', 0)
            ->get();

        // Fetch all relations of current user
        $relations = UserRequest::where(function ($q) use ($myProfile) {
            $q->where('sender_id', $myProfile->id)
              ->orWhere('receiver_id', $myProfile->id);
        })->get();

        // Add request status to each profile
        $profiles = $profiles->transform(function ($profile) use ($relations, $myProfile) {
            $profile->requestStatus = null;

            foreach ($relations as $relation) {
                $isMatch =
                    ($relation->sender_id == $myProfile->id && $relation->receiver_id == $profile->id) ||
                    ($relation->sender_id == $profile->id && $relation->receiver_id == $myProfile->id);

                if ($isMatch) {
                    if ($relation->is_accepted) {
                        $profile->requestStatus = 'friends';
                    } elseif ($relation->is_pending) {
                        $profile->requestStatus = $relation->sender_id == $myProfile->id ? 'sent' : 'received';
                    } elseif ($relation->is_rejected) {
                        $profile->requestStatus = 'rejected';
                    } elseif ($relation->is_blocked) {
                        $profile->requestStatus = 'blocked';
                    }
                    break;
                }
            }

            return $profile;
        });

        // Filter out profiles that already have a relation
        $profiles = $profiles->filter(fn($profile) => $profile->requestStatus === null)->values();

        return response()->json($profiles);
    }

    // Show a single profile
    public function show($id)
    {
        $profile = Profile::with(['user', 'images'])->where('user_id', $id)->first();

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        return response()->json($profile);
    }

    // Create a profile
    public function store(Request $request)
    {
        $request->validate([
            'age' => 'required|integer|min:18|max:100',
            'gender' => 'required|in:Male,Female',
            'religion' => 'required|string|max:50',
            'community' => 'required|string|max:50',
            'marital_status' => 'required|in:single,divorced,widow',
            'education' => 'required|string|max:500',
            'profession' => 'required|string|max:100',
            'preferences' => 'nullable|array',
            'country' => 'required|string|max:50',
            'state' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'visibility' => 'required|in:public,private',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $preferences = $request->preferences ?? [];

        $profile = Profile::create(array_merge($request->except('profile_image'), [
            'user_id' => Auth::id(),
            'preferences' => $preferences,
        ]));

        // Upload profile image
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/profiles', $fileName, 'public');

            $profile->images()->create([
                'user_id' => Auth::id(),
                'file_name' => $fileName,
                'file_path' => 'storage/' . $path,
                'Type_of_image' => 'profile',
            ]);
        }

        return response()->json($profile, 201);
    }

    // Update profile
    public function update(Request $request, $id)
    {
        $profile = Profile::where('user_id', $id)->first();

        if (!$profile || $profile->user_id != Auth::id()) {
            return response()->json(['message' => 'Unauthorized or profile not found'], 403);
        }

        $profile->update($request->except('profile_image'));

        // Update image
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/profiles', $fileName, 'public');

            $oldImage = $profile->images()->first();

            if ($oldImage) {
                if (Storage::disk('public')->exists(str_replace('storage/', '', $oldImage->file_path))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $oldImage->file_path));
                }
                $oldImage->update([
                    'file_name' => $fileName,
                    'file_path' => 'storage/' . $path,
                ]);
            } else {
                $profile->images()->create([
                    'user_id' => Auth::id(),
                    'file_name' => $fileName,
                    'file_path' => 'storage/' . $path,
                    'Type_of_image' => 'profile',
                ]);
            }
        }

        return response()->json($profile);
    }

    // Delete profile
    public function destroy($id)
    {
        $profile = Profile::where('user_id', $id)->first();

        if (!$profile || $profile->user_id != Auth::id()) {
            return response()->json(['message' => 'Unauthorized or profile not found'], 403);
        }

        // Delete images
        foreach ($profile->images as $image) {
            if (Storage::disk('public')->exists(str_replace('storage/', '', $image->file_path))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $image->file_path));
            }
            $image->delete();
        }

        $profile->delete();

        return response()->json(['message' => 'Profile deleted successfully']);
    }

    // Activate profile
    public function activate($id)
    {
        $profile = Profile::where('user_id', $id)->first();

        if (!$profile || $profile->user_id != Auth::id()) {
            return response()->json(['message' => 'Unauthorized or profile not found'], 403);
        }

        $profile->is_active = 0;
        $profile->save();

        return response()->json(['message' => 'Profile activated successfully']);
    }

    // Deactivate profile
    public function deactivate($id)
    {
        $profile = Profile::where('user_id', $id)->first();

        if (!$profile || $profile->user_id != Auth::id()) {
            return response()->json(['message' => 'Unauthorized or profile not found'], 403);
        }

        $profile->is_active = 1;
        $profile->save();

        return response()->json(['message' => 'Profile deactivated successfully']);
    }

    // Search profiles via query parameters
    public function search(Request $request)
    {
        $query = Profile::with(['user', 'images'])->where('is_active', 0);

        foreach (['gender', 'marital_status', 'religion', 'community', 'profession', 'country'] as $field) {
            if ($request->$field) {
                $query->where($field, 'like', '%' . $request->$field . '%');
            }
        }

        if ($request->age_from) $query->where('age', '>=', $request->age_from);
        if ($request->age_to) $query->where('age', '<=', $request->age_to);

        $profiles = $query->get();

        return response()->json($profiles);
    }

    // Get logged-in user's profile
    public function myProfile()
    {
        $profile = Profile::with(['user', 'images'])->where('user_id', Auth::id())->first();

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        return response()->json($profile);
    }
}
