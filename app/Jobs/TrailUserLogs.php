<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
// models
use App\Models\TrailsUserLogs;

class TrailUserLogs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $actions = [
        ['action' => 'Login'],
        ['action' => 'Logout'],
        ['action' => 'Update Profile']
    ];

    private $log;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($action, $ipaddress, $user)
    {
        foreach($this->actions as $actions) {
            if($actions['action'] === $action) {
                $this->log = array_merge($actions, ['users_id' => $user->id, 'ip_address' => $ipaddress]);
                break;
            }
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        TrailsUserLogs::create($this->log);
    }
}
