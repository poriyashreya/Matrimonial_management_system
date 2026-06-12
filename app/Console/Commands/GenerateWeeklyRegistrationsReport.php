<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class GenerateWeeklyRegistrationsReport extends Command
{
    protected $signature = 'report:weekly-registrations';
    protected $description = 'Generate weekly report on new user registrations';
    public function handle()
    {
        $startOfWeek = Carbon::now()->subWeek()->startOfWeek();
        $endOfWeek = Carbon::now()->subWeek()->endOfWeek();

        $newUsers = User::whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();
        $count = $newUsers->count();

        $reportContent = "Weekly User Registrations Report ({$startOfWeek->format('d M')} - {$endOfWeek->format('d M')}):\n\n";
        $reportContent .= "Total New Users: {$count}\n\n";

        foreach ($newUsers as $user) {
            $reportContent .= "Name: {$user->name}, Email: {$user->email}, Role: {$user->role}\n";
        }

        // Send to admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Mail::raw($reportContent, function ($message) use ($admin) {
                $message->to($admin->email)
                        ->subject('Weekly User Registrations Report');
            });
        }

        $this->info("Weekly report sent to admins. Total new users: {$count}");
    }
}
