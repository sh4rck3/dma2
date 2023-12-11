<?php

namespace App\Listeners\Audit;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use App\Models\AuditLog;
use Request;


class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event)
    {
        //
        AuditLog::create([
            'user_id' => $event->user->id,
            'event' => 'login',
            'auditable_type' => get_class($event->user),
            'auditable_id' => $event->user->id,
            'old_values' => null,
            'new_values' => null,
            'url' => Request::fullUrl(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'tags' => null,
        ]);
    }
}
