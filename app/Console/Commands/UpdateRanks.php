<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\GameController;

class UpdateRanks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'games:update-ranks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the popularity and score ranks';

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
     * @return mixed
     */
    public function handle()
    {
        GameController::updateRatings();
    }
}
