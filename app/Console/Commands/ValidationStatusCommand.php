<?php

namespace App\Console\Commands;

use App\Models\WorkOrder;
use App\Models\WorkOrderLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ValidationStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'validation:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       
    }
}
