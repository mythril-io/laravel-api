<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class AddInitialData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create admin role
        Role::create(['name' => 'admin', 'guard_name' => 'api']);

        // Create Play Statuses
        DB::table('play_statuses')->insert([
            ['name' => 'Currently Playing'],
            ['name' => 'Planning'],
            ['name' => 'Completed'],
            ['name' => 'On Hold'],
            ['name' => 'Dropped']
        ]);

        // Create Genres
        DB::table('genres')->insert([
            ['name' => 'Role-Playing Game', 'acronym' => 'RPG'],
            ['name' => 'Action Role-Playing Game', 'acronym' => 'ARPG'],
            ['name' => 'First Person Shooter', 'acronym' => 'FPS'],
            ['name' => 'Action', 'acronym' => 'Action'],
            ['name' => 'Adventure', 'acronym' => 'Adventure'],
            ['name' => 'Action Adventure', 'acronym' => 'Action Adventure'],
            ['name' => 'MMORPG', 'acronym' => 'MMORPG'],
            ['name' => 'Strategy', 'acronym' => 'Strategy'],
            ['name' => 'Real Time Strategy', 'acronym' => 'RTS'],
            ['name' => 'Fighting', 'acronym' => 'Fighting']
        ]);

        // Create Platforms
        DB::table('platforms')->insert([
            ['name' => 'PC', 'acronym' => 'PC'],
            ['name' => 'Playstation', 'acronym' => 'PS'],
            ['name' => 'Playstation 2', 'acronym' => 'PS2'],
            ['name' => 'Playstation 3', 'acronym' => 'PS3'],
            ['name' => 'Playstation 4', 'acronym' => 'PS4'],
            ['name' => 'Playstation 5', 'acronym' => 'PS5'],
            ['name' => 'Playstation Portable', 'acronym' => 'PSP'],
            ['name' => 'Playstation Vita', 'acronym' => 'Vita'],
            ['name' => 'Nintendo', 'acronym' => 'NES'],
            ['name' => 'Super Nintendo', 'acronym' => 'SNES'],
            ['name' => 'Nintendo 64', 'acronym' => 'N64'],
            ['name' => 'Gamecube', 'acronym' => 'GCN'],
            ['name' => 'Nintendo Wii', 'acronym' => 'Wii'],
            ['name' => 'Nintendo Wii U', 'acronym' => 'Wii U'],
            ['name' => 'Nintendo Switch', 'acronym' => 'Switch'],
            ['name' => 'Game Boy', 'acronym' => 'GB'],
            ['name' => 'Game Boy Color', 'acronym' => 'GBC'],
            ['name' => 'Game Boy Advance', 'acronym' => 'GBA'],
            ['name' => 'Nintendo DS', 'acronym' => 'NDS'],
            ['name' => 'Nintendo 3DS', 'acronym' => 'N3DS'],
            ['name' => 'New Nintendo 3DS', 'acronym' => 'NN3DS'],
            ['name' => 'Xbox', 'acronym' => 'Xbox'],
            ['name' => 'Xbox 360', 'acronym' => '360'],
            ['name' => 'Xbox One', 'acronym' => 'Xbox One'],
            ['name' => 'Xbox Series X', 'acronym' => 'Series X']
        ]);

        // Create Developers
        DB::table('developers')->insert([
            ['name' => 'Square-Enix', 'country' => 'Japan'],
            ['name' => 'Squaresoft', 'country' => 'Japan'],
            ['name' => 'Nintendo', 'country' => 'Japan'],
            ['name' => 'Atlus', 'country' => 'Japan'],
            ['name' => 'Capcom', 'country' => 'Japan'],
            ['name' => 'Game Freak', 'country' => 'Japan'],
            ['name' => 'FromSoftware', 'country' => 'Japan'],
            ['name' => 'PlatinumGames', 'country' => 'Japan'],
            ['name' => 'Vanillaware', 'country' => 'Japan'],
            ['name' => 'Sega', 'country' => 'Japan'],
            ['name' => 'Sony Interactive Entertainment', 'country' => 'Japan'],
            ['name' => 'Japan Studio', 'country' => 'Japan'],
            ['name' => 'Polyphony Digital', 'country' => 'Japan'],
            ['name' => 'Grezzo', 'country' => 'Japan'],
            ['name' => 'HAL Laboratory', 'country' => 'Japan'],
            ['name' => 'Level-5', 'country' => 'Japan'],
            ['name' => 'Monolith Soft', 'country' => 'Japan'],
            ['name' => 'h.a.n.d.', 'country' => 'Japan'],
            ['name' => 'Namco Tales Studio', 'country' => 'Japan'],
            ['name' => 'Silicon Studio', 'country' => 'Japan'],
            ['name' => 'Arc System Works', 'country' => 'Japan'],
            
            ['name' => 'Blizzard Entertainment', 'country' => 'USA'],
            ['name' => 'Blizzard North', 'country' => 'USA'],
            ['name' => 'Riot Games', 'country' => 'USA'],
            ['name' => 'Valve', 'country' => 'USA'],
            ['name' => 'Xbox Game Studios', 'country' => 'USA'],
            ['name' => 'Naughty Dog', 'country' => 'USA'],
            ['name' => 'Bluepoint Games', 'country' => 'USA'],
            ['name' => 'Bethesda Game Studios', 'country' => 'USA'],
            ['name' => 'Rockstar Games', 'country' => 'USA'],
            ['name' => 'Rockstar North', 'country' => 'USA'],
            ['name' => 'Rockstar San Diego', 'country' => 'USA'],
            ['name' => 'Sucker Punch Productions', 'country' => 'USA'],
            ['name' => 'Obsidian Entertainment', 'country' => 'USA'],
            ['name' => 'Retro Studios', 'country' => 'USA'],

            ['name' => 'CD Projekt Red', 'country' => 'Poland'],
            ['name' => 'Guerrilla Games', 'country' => 'Netherlands'],
            ['name' => 'Lionhead Studios', 'country' => 'United Kingdom'],
            ['name' => 'Ninja Theory', 'country' => 'United Kingdom'],
            ['name' => 'Rare', 'country' => 'United Kingdom']

        ]);

        // Create Publishers
        DB::table('publishers')->insert([
            ['name' => 'Square-Enix', 'country' => 'Japan'],
            ['name' => 'Square', 'country' => 'Japan'],
            ['name' => 'Nintendo', 'country' => 'Japan'],
            ['name' => 'Capcom', 'country' => 'Japan'],
            ['name' => 'Sega', 'country' => 'Japan'],
            ['name' => 'Atlus', 'country' => 'Japan'],
            ['name' => 'FromSoftware', 'country' => 'Japan'],
            
            ['name' => 'Blizzard Entertainment', 'country' => 'USA'],
            ['name' => 'Activision Blizzard', 'country' => 'USA'],
            ['name' => 'Sony Computer Entertainment', 'country' => 'USA'],
            ['name' => 'Square Electronic Arts', 'country' => 'USA'],
            ['name' => 'Microsoft', 'country' => 'USA'],
            ['name' => 'Rockstar Games', 'country' => 'USA'],
            ['name' => 'Bethesda Softworks', 'country' => 'USA'],
            ['name' => 'Riot Games', 'country' => 'USA'],
            ['name' => 'Valve', 'country' => 'USA'],
            ['name' => 'Atlus USA', 'country' => 'USA'],
            ['name' => 'NIS America', 'country' => 'USA'],
            ['name' => 'Bandai Namco Entertainment', 'country' => 'North America'],

            ['name' => 'CD Projekt', 'country' => 'Poland']

        ]);

        // Create Regions
        DB::table('regions')->insert([
            ['name' => 'North America', 'acronym' => 'NA'],
            ['name' => 'Japan', 'acronym' => 'JP'],
            ['name' => 'Europe', 'acronym' => 'EU']
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
