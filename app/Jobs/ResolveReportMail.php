<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Report;
use App\Notifications\ReportNotification;
use App\Mail\ReportActionMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;


class ResolveReportMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $userId,
        public string $actionMessage,
        public int $reportId,
        public int $profileId,
        public string $userName
    ){}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::find($this->userId);
        if(!$user){
            return;
        }

        $user->notify(
            new ReportNotification($this->actionMessage,$this->reportId
        ));

        Mail::to($user->email)->send(
                new ReportActionMail(
                $this->actionMessage,
                $this->profileId,
                $this->userName
            )
        );
    }
}

