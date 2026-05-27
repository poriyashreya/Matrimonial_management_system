<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Support\Facades\Mail;


class NotifyPendingVerifications extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'notify:pending-verifications';

    /**
     * The console command description.
     */
    protected $description = 'Notify admins of pending profile verifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pendingCount = Verification::where('status', 0)->count();

        if ($pendingCount === 0) {
            $this->info('No pending verifications.');
            return;
        }

        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Mail::raw(
                "⚠ There are {$pendingCount} pending profile verifications awaiting review.",
                function ($message) use ($admin) {
                    $message->to($admin->email)
                            ->subject('Pending Profile Verifications');
                }
            );
        }

        $this->info("Admins notified: {$pendingCount} pending verifications.");
    }

}

