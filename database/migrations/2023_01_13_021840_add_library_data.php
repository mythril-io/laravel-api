<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\User;
use App\Game;
use App\PlayStatus;

class AddLibraryData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('libraries')->insert([
            [
                'user_id' => User::firstWhere('username', 'Cloud')->id,
                'release_id' => Game::firstWhere('title', 'Final Fantasy VII')->releases()->first()->id,
                'play_status_id' => PlayStatus::firstWhere('name', 'Completed')->id,
                'score' => 10,
                'own'=> true,
                'digital' => false,
                'created_at' => \Carbon\Carbon::now()->subMonths(2)->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->subMonths(2)->toDateTimeString()
            ],
            [
                'user_id' => User::firstWhere('username', 'Sephiroth')->id,
                'release_id' => Game::firstWhere('title', 'Final Fantasy VII')->releases()->first()->id,
                'play_status_id' => PlayStatus::firstWhere('name', 'Completed')->id,
                'score' => 10,
                'own'=> true,
                'digital' => false,
                'created_at' => \Carbon\Carbon::now()->subMonths(2)->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->subMonths(2)->toDateTimeString()
            ],
            [
                'user_id' => User::firstWhere('username', 'Sephiroth')->id,
                'release_id' => Game::firstWhere('title', 'Final Fantasy VII Remake')->releases()->first()->id,
                'play_status_id' => PlayStatus::firstWhere('name', 'Completed')->id,
                'score' => 10,
                'own'=> true,
                'digital' => false,
                'created_at' => \Carbon\Carbon::now()->subMonths(1)->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->subMonths(1)->toDateTimeString()
            ],
            [
                'user_id' => User::firstWhere('username', 'Sephiroth')->id,
                'release_id' => Game::firstWhere('title', '13 Sentinels: Aegis Rim')->releases()->first()->id,
                'play_status_id' => PlayStatus::firstWhere('name', 'Currently Playing')->id,
                'score' => 9,
                'own'=> true,
                'digital' => true,
                'created_at' => \Carbon\Carbon::now()->subDays(15)->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->subDays(15)->toDateTimeString()
            ],
            [
                'user_id' => User::firstWhere('username', 'Zelda')->id,
                'release_id' => Game::firstWhere('title', 'The Legend of Zelda: Breath of the Wild')->releases()->first()->id,
                'play_status_id' => PlayStatus::firstWhere('name', 'Currently Playing')->id,
                'score' => 10,
                'own'=> true,
                'digital' => false,
                'created_at' => \Carbon\Carbon::now()->subDays(12)->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->subDays(12)->toDateTimeString()
            ],
            [
                'user_id' => User::firstWhere('username', 'Cloud')->id,
                'release_id' => Game::firstWhere('title', 'Final Fantasy VII Remake')->releases()->first()->id,
                'play_status_id' => PlayStatus::firstWhere('name', 'Currently Playing')->id,
                'score' => 10,
                'own'=> true,
                'digital' => false,
                'created_at' => \Carbon\Carbon::now()->subDays(10)->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->subDays(10)->toDateTimeString()
            ],
            [
                'user_id' => User::firstWhere('username', 'Hunter')->id,
                'release_id' => Game::firstWhere('title', 'Nier: Automata')->releases()->first()->id,
                'play_status_id' => PlayStatus::firstWhere('name', 'Currently Playing')->id,
                'score' => 10,
                'own'=> true,
                'digital' => false,
                'created_at' => \Carbon\Carbon::now()->subDays(5)->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->subDays(5)->toDateTimeString()
            ],
            [
                'user_id' => User::firstWhere('username', 'Balthier')->id,
                'release_id' => Game::firstWhere('title', 'Diablo IV')->releases()->first()->id,
                'play_status_id' => PlayStatus::firstWhere('name', 'Currently Playing')->id,
                'score' => 10,
                'own'=> true,
                'digital' => false,
                'created_at' => \Carbon\Carbon::now()->subDays(3)->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->subDays(3)->toDateTimeString()
            ],
            [
                'user_id' => User::firstWhere('username', 'Zelda')->id,
                'release_id' => Game::firstWhere('title', 'The Legend of Zelda: Tears of the Kingdom')->releases()->first()->id,
                'play_status_id' => PlayStatus::firstWhere('name', 'Planning')->id,
                'score' => 10,
                'own'=> true,
                'digital' => false,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ],

        ]);

        // Add favourites
        $release = Game::firstWhere('title', 'Final Fantasy VII')->releases()->first();
        User::firstWhere('username', 'Cloud')->toggleFavorite($release);
        User::firstWhere('username', 'Sephiroth')->toggleFavorite($release);

        $release = Game::firstWhere('title', 'Final Fantasy VII Remake')->releases()->first();
        User::firstWhere('username', 'Cloud')->toggleFavorite($release);
        User::firstWhere('username', 'Sephiroth')->toggleFavorite($release);

        $release = Game::firstWhere('title', '13 Sentinels: Aegis Rim')->releases()->first();
        User::firstWhere('username', 'Sephiroth')->toggleFavorite($release);

        $release = Game::firstWhere('title', 'The Legend of Zelda: Breath of the Wild')->releases()->first();
        User::firstWhere('username', 'Zelda')->toggleFavorite($release);
        User::firstWhere('username', 'Link')->toggleFavorite($release);

        $release = Game::firstWhere('title', 'Nier: Automata')->releases()->first();
        User::firstWhere('username', 'Hunter')->toggleFavorite($release);
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
