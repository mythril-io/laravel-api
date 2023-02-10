<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\User;
use App\Game;

class AddReviewData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $lipsum = new joshtronic\LoremIpsum();

        DB::table('reviews')->insert([
            [
                'user_id' => User::where('username', 'Cloud')->first()->id,
                'release_id' => Game::firstWhere('title', 'Final Fantasy VII Remake')->releases()->first()->id,
                'summary' => $lipsum->sentence(1),
                'content' => $lipsum->paragraphs(3),
                'score' => 95,
                'created_at' => \Carbon\Carbon::now()->subMonths(3)->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->subMonths(3)->toDateTimeString()
            ],
            [
                'user_id' => User::where('username', 'Sephiroth')->first()->id,
                'release_id' => Game::firstWhere('title', '13 Sentinels: Aegis Rim')->releases()->first()->id,
                'summary' => $lipsum->sentence(1),
                'content' => $lipsum->paragraphs(3),
                'score' => 90,
                'created_at' => \Carbon\Carbon::now()->subMonths(2)->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->subMonths(2)->toDateTimeString()
            ],
            [
                'user_id' => User::where('username', 'Hunter')->first()->id,
                'release_id' => Game::firstWhere('title', 'Elden Ring')->releases()->first()->id,
                'summary' => $lipsum->sentence(1),
                'content' => $lipsum->paragraphs(3),
                'score' => 100,
                'created_at' => \Carbon\Carbon::now()->subMonths(1)->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->subMonths(1)->toDateTimeString()
            ],
            [
                'user_id' => User::where('username', 'Tracer')->first()->id,
                'release_id' => Game::firstWhere('title', 'Overwatch 2')->releases()->first()->id,
                'summary' => $lipsum->sentence(1),
                'content' => $lipsum->paragraphs(3),
                'score' => 90,
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
