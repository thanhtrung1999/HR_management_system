<?php

namespace App\Jobs;

use App\Mail\EmployeeRequestForManager;
use App\Mail\EmployeeRequestForRoot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailRequestOfEmployee implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emailRoot = new EmployeeRequestForRoot($this->data);
        $emailManager = new EmployeeRequestForManager($this->data);
        Mail::to($this->data['email_root'])->send($emailRoot);
        Mail::to($this->data['email_manager'])->send($emailManager);
    }
}
