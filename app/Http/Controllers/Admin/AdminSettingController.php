<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\admin_images;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminSettingController extends Controller
{
    public function index()
    {
        // Fetch admin user
        $admin = User::where('role', 'admin')->first();
        $upload = DB::table('admin_images')
            ->select('file_path')
            ->first();

        return view('admin.settings.index', compact('admin', 'upload'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $admin = User::where('role', 'admin')->first();

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Admin details updated successfully');
    }

}
