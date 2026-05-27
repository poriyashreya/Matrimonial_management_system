<?php

namespace App\Http\Controllers;

use App\Models\Filter;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilterController extends Controller
{
    // SAVE FILTER
    public function saveresult(Request $request)
    {
        $profile = Profile::where('user_id', Auth::id())->first();

        if (!$profile) {
            return back()->with('error', 'Profile not found!');
        }

        Filter::create([
            'profile_id'     => $profile->id,
            'age_from'       => $request->age_from,
            'age_to'         => $request->age_to,
            'gender'         => $request->gender,
            'religion'       => $request->religion,
            'community'      => $request->community,
            'profession'     => $request->profession,
            'country'        => $request->country,
            'state'          => $request->state,
            'city'           => $request->city,
            'marital_status' => $request->marital_status,
        ]);

        return back()->with('success', 'Filter saved successfully!');
    }

    // 🔥 REMOVE ONLY ONE FILTER FIELD
    public function removeField($filterId, $field)
    {
        $filter = Filter::findOrFail($filterId);

        // Security check
        if ($filter->profile->user_id !== Auth::id()) {
            abort(403);
        }

        // Age uses two columns
        if ($field === 'age') {
            $filter->update([
                'age_from' => null,
                'age_to'   => null,
            ]);
        } else {
            if (!in_array($field, $filter->getFillable())) {
                abort(400, 'Invalid filter field');
            }

            $filter->update([$field => null]);
        }

        // 🔥 If ALL filter fields are NULL → delete row
        $remaining = collect($filter->only($filter->getFillable()))
            ->filter(fn ($v) => $v !== null);

        if ($remaining->isEmpty()) {
            $filter->delete();
        }

        return back()->with('success', 'Filter updated!');
    }
}
