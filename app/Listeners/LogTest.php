<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogTest
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Foundation\Http\Events\RequestHandled  $event
     * @return void
     */
    public function handle($event)
    {
        // $request = $event->request;
        // $response = $event->response;
        // $path = $request->path();
        // $method = $request->method();
        // $body = $request->all();


    }
}
