<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\User;
use App\Game;

class AddRecommendationData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $lipsum = new joshtronic\LoremIpsum();

        DB::table('recommendations')->insert([
            [
                'user_id' => User::where('username', 'Balthier')->first()->id,
                'release_id' => Game::firstWhere('title', 'The Witcher 3: Wild Hunt')->releases()->first()->id,
                'second_release_id' => Game::firstWhere('title', 'Cyberpunk 2077')->releases()->first()->id,
                'content' => $lipsum->paragraphs(3),
                'created_at' => \Carbon\Carbon::now()->subMonths(2)->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->subMonths(2)->toDateTimeString()
            ],
            [
                'user_id' => User::where('username', 'Cloud')->first()->id,
                'release_id' => Game::firstWhere('title', '13 Sentinels: Aegis Rim')->releases()->first()->id,
                'second_release_id' => Game::firstWhere('title', 'Persona 4')->releases()->first()->id,
                'content' => $lipsum->paragraphs(3),
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ],
        ]);  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
