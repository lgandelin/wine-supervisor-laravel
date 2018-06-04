<?php

namespace Webaccess\WineSupervisorLaravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendMailingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

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
        $email = $this->data->email;
        $title = $this->data->title;

        Mail::send('wine-supervisor::emails.mailing', array(
            'text' => $this->data->text,
            'title' => $this->data->title,
            'image' => $this->data->image,
            'lang' => $this->data->lang
        ), function ($message) use ($email, $title) {
            $message->to($email)->subject($title);
        });
    }
}
