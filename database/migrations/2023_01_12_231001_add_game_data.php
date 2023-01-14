<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Developer;
use App\Publisher;
use App\Region;
use App\Genre;
use App\Platform;
use App\Game;
use App\Release;

class AddGameData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $lipsum = new joshtronic\LoremIpsum();

        // Create Game
        $game = Game::create([
            'title' => 'Final Fantasy VII',
            'slug' => Str::slug('Final Fantasy VII'),
            'synopsis' => $lipsum->paragraphs(2),
            'icon' => Str::slug('Final Fantasy VII').".png",
            'banner' => Str::slug('Final Fantasy VII').".jpg",
            'developer_id' => Developer::firstWhere('name', 'Squaresoft')->id,
            'user_id' => 1
        ]);
        $game->genres()->saveMany([
            Genre::firstWhere('name', 'Role-Playing Game')
        ]);
        $game->releases()->saveMany([
            new Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Playstation')->id,
                'region_id' => Region::firstWhere('acronym', 'NA')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Sony Computer Entertainment')->id,
                'date' => '1997-09-07',
                'date_type_id' => 1
            ]),
            new Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Playstation')->id,
                'region_id' => Region::firstWhere('acronym', 'JP')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Square')->id,
                'date' => '1997-01-31',
                'date_type_id' => 1
            ]),
            new Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Playstation')->id,
                'region_id' => Region::firstWhere('acronym', 'EU')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Sony Computer Entertainment')->id,
                'date' => '1997-11-17',
                'date_type_id' => 1
            ]),
            new Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Playstation')->id,
                'region_id' => Region::firstWhere('acronym', 'JP')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Square')->id,
                'date' => '1997-10-02',
                'date_type_id' => 1,
                'alternate_title' => 'Final Fantasy VII International'
            ])
        ]);

        // Create Game
        $game = Game::create([
            'title' => 'Final Fantasy VII Remake',
            'slug' => Str::slug('Final Fantasy VII Remake'),
            'synopsis' => $lipsum->paragraphs(2),
            'icon' => Str::slug('Final Fantasy VII Remake').".png",
            'banner' => Str::slug('Final Fantasy VII Remake').".jpg",
            'developer_id' => Developer::firstWhere('name', 'Square-Enix')->id,
            'user_id' => 1
        ]);
        $game->genres()->saveMany([
            Genre::firstWhere('name', 'Action Role-Playing Game')
        ]);
        $game->releases()->saveMany([
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Playstation 4')->id,
                'region_id' => Region::firstWhere('acronym', 'NA')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Square-Enix')->id,
                'date' => '2020-04-10',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Playstation 4')->id,
                'region_id' => Region::firstWhere('acronym', 'JP')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Square-Enix')->id,
                'date' => '2020-04-10',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Playstation 4')->id,
                'region_id' => Region::firstWhere('acronym', 'EU')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Square-Enix')->id,
                'date' => '2020-04-10',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Playstation 5')->id,
                'region_id' => Region::firstWhere('acronym', 'JP')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Square-Enix')->id,
                'date' => '2021-06-10',
                'date_type_id' => 1,
                'alternate_title' => 'Final Fantasy VII Remake Intergrade'
            ])
        ]);

        // Create Game
        $game = Game::create([
            'title' => 'The Legend of Zelda: Breath of the Wild',
            'slug' => Str::slug('The Legend of Zelda: Breath of the Wild'),
            'synopsis' => $lipsum->paragraphs(2),
            'icon' => Str::slug('The Legend of Zelda: Breath of the Wild').".png",
            'banner' => Str::slug('The Legend of Zelda: Breath of the Wild').".jpg",
            'developer_id' => Developer::firstWhere('name', 'Nintendo')->id,
            'user_id' => 1
        ]);
        $game->genres()->saveMany([
            Genre::firstWhere('name', 'Action Adventure')
        ]);
        $game->releases()->saveMany([
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Nintendo Switch')->id,
                'region_id' => Region::firstWhere('acronym', 'JP')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Nintendo')->id,
                'date' => '2017-03-03',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Nintendo Switch')->id,
                'region_id' => Region::firstWhere('acronym', 'NA')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Nintendo')->id,
                'date' => '2017-03-03',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Nintendo Switch')->id,
                'region_id' => Region::firstWhere('acronym', 'EU')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Nintendo')->id,
                'date' => '2017-03-03',
                'date_type_id' => 1
            ])
        ]);

        // Create Game
        $game = Game::create([
            'title' => 'The Legend of Zelda: Tears of the Kingdom',
            'slug' => Str::slug('The Legend of Zelda: Tears of the Kingdom'),
            'synopsis' => $lipsum->paragraphs(2),
            'icon' => Str::slug('The Legend of Zelda: Tears of the Kingdom').".png",
            'banner' => Str::slug('The Legend of Zelda: Tears of the Kingdom').".jpg",
            'developer_id' => Developer::firstWhere('name', 'Nintendo')->id,
            'user_id' => 1
        ]);
        $game->genres()->saveMany([
            Genre::firstWhere('name', 'Action Adventure')
        ]);
        $game->releases()->saveMany([
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Nintendo Switch')->id,
                'region_id' => Region::firstWhere('acronym', 'JP')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Nintendo')->id,
                'date' => '2023-05-12',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Nintendo Switch')->id,
                'region_id' => Region::firstWhere('acronym', 'NA')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Nintendo')->id,
                'date' => '2023-05-12',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Nintendo Switch')->id,
                'region_id' => Region::firstWhere('acronym', 'EU')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Nintendo')->id,
                'date' => '2023-05-12',
                'date_type_id' => 1
            ])
        ]);

        // Create Game
        $game = Game::create([
            'title' => 'Nier: Automata',
            'slug' => Str::slug('Nier: Automata'),
            'synopsis' => $lipsum->paragraphs(2),
            'icon' => Str::slug('Nier: Automata').".png",
            'banner' => Str::slug('Nier: Automata').".jpg",
            'developer_id' => Developer::firstWhere('name', 'PlatinumGames')->id,
            'user_id' => 1
        ]);
        $game->genres()->saveMany([
            Genre::firstWhere('name', 'Action Adventure')
        ]);
        $game->releases()->saveMany([
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Playstation 4')->id,
                'region_id' => Region::firstWhere('acronym', 'JP')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Square-Enix')->id,
                'date' => '2017-02-23',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Playstation 4')->id,
                'region_id' => Region::firstWhere('acronym', 'NA')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Square-Enix')->id,
                'date' => '2017-03-07',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Playstation 4')->id,
                'region_id' => Region::firstWhere('acronym', 'EU')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Square-Enix')->id,
                'date' => '2017-05-10',
                'date_type_id' => 1
            ])
        ]);

        // Create Game
        $game = Game::create([
            'title' => 'Diablo II',
            'slug' => Str::slug('Diablo II'),
            'synopsis' => $lipsum->paragraphs(2),
            'icon' => Str::slug('Diablo II').".png",
            'banner' => Str::slug('Diablo II').".jpg",
            'developer_id' => Developer::firstWhere('name', 'Blizzard North')->id,
            'user_id' => 1
        ]);
        $game->genres()->saveMany([
            Genre::firstWhere('name', 'Action Role-Playing Game')
        ]);
        $game->releases()->saveMany([
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'PC')->id,
                'region_id' => Region::firstWhere('acronym', 'NA')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Blizzard Entertainment')->id,
                'date' => '2000-06-28',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'PC')->id,
                'region_id' => Region::firstWhere('acronym', 'EU')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Blizzard Entertainment')->id,
                'date' => '2000-06-30',
                'date_type_id' => 1
            ])
        ]);

        // Create Game
        $game = Game::create([
            'title' => 'Diablo IV',
            'slug' => Str::slug('Diablo IV'),
            'synopsis' => $lipsum->paragraphs(2),
            'icon' => Str::slug('Diablo IV').".png",
            'banner' => Str::slug('Diablo IV').".jpg",
            'developer_id' => Developer::firstWhere('name', 'Blizzard Entertainment')->id,
            'user_id' => 1
        ]);
        $game->genres()->saveMany([
            Genre::firstWhere('name', 'Action Role-Playing Game')
        ]);
        $game->releases()->saveMany([
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'PC')->id,
                'region_id' => Region::firstWhere('acronym', 'NA')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Blizzard Entertainment')->id,
                'date' => '2023-06-06',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'PC')->id,
                'region_id' => Region::firstWhere('acronym', 'EU')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Blizzard Entertainment')->id,
                'date' => '2023-06-06',
                'date_type_id' => 1
            ])
        ]);

        // Create Game
        $game = Game::create([
            'title' => '13 Sentinels: Aegis Rim',
            'slug' => Str::slug('13 Sentinels: Aegis Rim'),
            'synopsis' => $lipsum->paragraphs(2),
            'icon' => Str::slug('13 Sentinels: Aegis Rim').".png",
            'banner' => Str::slug('13 Sentinels: Aegis Rim').".jpg",
            'developer_id' => Developer::firstWhere('name', 'Vanillaware')->id,
            'user_id' => 1
        ]);
        $game->genres()->saveMany([
            Genre::firstWhere('name', 'Adventure'),
            Genre::firstWhere('name', 'Real Time Strategy')
        ]);
        $game->releases()->saveMany([
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Playstation 4')->id,
                'region_id' => Region::firstWhere('acronym', 'JP')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Atlus')->id,
                'date' => '2019-11-28',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Playstation 4')->id,
                'region_id' => Region::firstWhere('acronym', 'NA')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Sega')->id,
                'date' => '2020-09-22',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Playstation 4')->id,
                'region_id' => Region::firstWhere('acronym', 'EU')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Sega')->id,
                'date' => '2020-09-22',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Nintendo Switch')->id,
                'region_id' => Region::firstWhere('acronym', 'JP')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Atlus')->id,
                'date' => '2022-04-14',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Nintendo Switch')->id,
                'region_id' => Region::firstWhere('acronym', 'NA')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Sega')->id,
                'date' => '2022-04-12',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Nintendo Switch')->id,
                'region_id' => Region::firstWhere('acronym', 'EU')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Sega')->id,
                'date' => '2022-04-12',
                'date_type_id' => 1
            ])
        ]);

        // Create Game
        $game = Game::create([
            'title' => 'Persona 4',
            'slug' => Str::slug('Persona 4'),
            'synopsis' => $lipsum->paragraphs(2),
            'icon' => Str::slug('Persona 4').".png",
            'banner' => Str::slug('Persona 4').".jpg",
            'developer_id' => Developer::firstWhere('name', 'Atlus')->id,
            'user_id' => 1
        ]);
        $game->genres()->saveMany([
            Genre::firstWhere('name', 'Role-Playing Game')
        ]);
        $game->releases()->saveMany([
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Playstation 2')->id,
                'region_id' => Region::firstWhere('acronym', 'JP')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Atlus')->id,
                'date' => '2008-07-10',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Playstation 2')->id,
                'region_id' => Region::firstWhere('acronym', 'NA')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Atlus USA')->id,
                'date' => '2008-12-09',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Playstation 2')->id,
                'region_id' => Region::firstWhere('acronym', 'EU')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Square-Enix')->id,
                'date' => '2009-03-13',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Playstation Vita')->id,
                'region_id' => Region::firstWhere('acronym', 'JP')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Atlus')->id,
                'date' => '2012-06-14',
                'date_type_id' => 1,
                'alternate_title' => 'Persona 4 Golden'
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Playstation Vita')->id,
                'region_id' => Region::firstWhere('acronym', 'NA')->id,
                'publisher_id' => Publisher::firstWhere('name', 'Atlus USA')->id,
                'date' => '2012-11-20',
                'date_type_id' => 1,
                'alternate_title' => 'Persona 4 Golden'
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'Playstation Vita')->id,
                'region_id' => Region::firstWhere('acronym', 'EU')->id,
                'publisher_id' => Publisher::firstWhere('name', 'NIS America')->id,
                'date' => '2013-02-22',
                'date_type_id' => 1,
                'alternate_title' => 'Persona 4 Golden'
            ])
        ]);


        // Create Game
        $game = Game::create([
            'title' => 'The Witcher 3: Wild Hunt',
            'slug' => Str::slug('The Witcher 3: Wild Hunt'),
            'synopsis' => $lipsum->paragraphs(2),
            'icon' => Str::slug('The Witcher 3: Wild Hunt').".png",
            'banner' => Str::slug('The Witcher 3: Wild Hunt').".jpg",
            'developer_id' => Developer::firstWhere('name', 'CD Projekt Red')->id,
            'user_id' => 1
        ]);
        $game->genres()->saveMany([
            Genre::firstWhere('name', 'Action Role-Playing Game')
        ]);
        $game->releases()->saveMany([
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'PC')->id,
                'region_id' => Region::firstWhere('acronym', 'NA')->id,
                'publisher_id' => Publisher::firstWhere('name', 'CD Projekt')->id,
                'date' => '2015-05-19',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'PC')->id,
                'region_id' => Region::firstWhere('acronym', 'EU')->id,
                'publisher_id' => Publisher::firstWhere('name', 'CD Projekt')->id,
                'date' => '2015-05-19',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'PC')->id,
                'region_id' => Region::firstWhere('acronym', 'JP')->id,
                'publisher_id' => Publisher::firstWhere('name', 'CD Projekt')->id,
                'date' => '2015-05-19',
                'date_type_id' => 1
            ])
        ]);

        // Create Game
        $game = Game::create([
            'title' => 'Cyberpunk 2077',
            'slug' => Str::slug('Cyberpunk 2077'),
            'synopsis' => $lipsum->paragraphs(2),
            'icon' => Str::slug('Cyberpunk 2077').".png",
            'banner' => Str::slug('Cyberpunk 2077').".jpg",
            'developer_id' => Developer::firstWhere('name', 'CD Projekt Red')->id,
            'user_id' => 1
        ]);
        $game->genres()->saveMany([
            Genre::firstWhere('name', 'First Person Shooter')
        ]);
        $game->releases()->saveMany([
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'PC')->id,
                'region_id' => Region::firstWhere('acronym', 'NA')->id,
                'publisher_id' => Publisher::firstWhere('name', 'CD Projekt')->id,
                'date' => '2020-12-10',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'PC')->id,
                'region_id' => Region::firstWhere('acronym', 'EU')->id,
                'publisher_id' => Publisher::firstWhere('name', 'CD Projekt')->id,
                'date' => '2020-12-10',
                'date_type_id' => 1
            ]),
            new App\Release([
                'game_id' => $game->id,
                'platform_id' => Platform::firstWhere('name', 'PC')->id,
                'region_id' => Region::firstWhere('acronym', 'JP')->id,
                'publisher_id' => Publisher::firstWhere('name', 'CD Projekt')->id,
                'date' => '2020-12-10',
                'date_type_id' => 1
            ])
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
