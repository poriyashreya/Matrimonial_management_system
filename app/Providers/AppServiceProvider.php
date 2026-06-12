<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $favicon = DB::table('admin_images')
            ->where('type_of_image', 'favicon')
            ->value('file_path'); // ✅ column name

        $logo = DB::table('admin_images')
            ->where('type_of_image', 'logo')
            ->value('file_path');

        View::share([
            'adminFavicon' => $favicon,
            'logo' => $logo
        ]);
    }
}
