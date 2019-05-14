<?php

namespace App\Listeners;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SqlListener
{

    public function __construct()
    {
    }

    public function handle(QueryExecuted $event)
    {
        $sql = str_replace("?", "'%s'", $event->sql);
        $log = vsprintf($sql, $event->bindings);
        $log = '[' . date('Y-m-d H:i:s') . '] ' . $log . "\r\n";
        Log::stack(['db'])->info($log);
    }
}
