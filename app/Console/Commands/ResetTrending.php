<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class ResetTrending extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'games:reset-trending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the trending views for all games';

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
        DB::transaction(function () {
            DB::table('games')->update(['trending_page_views' => 0]);
        });
    }
}
