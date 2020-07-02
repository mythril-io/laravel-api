<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game, App\Release, App\User, App\Developer, App\Publisher, App\Genre, App\Platform;

class AdminController extends Controller
{
    /**
     * Stats.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $games_count = Game::all()->count();
        $releases_count = Release::all()->count();
        $developers_count = Developer::all()->count();
        $publishers_count = Publisher::all()->count();
        $genres_count = Genre::all()->count();
        $platform_count = Platform::all()->count();

        $recent_games = Game::orderBy('created_at', 'desc')->limit(5)->get();
        $recent_users = User::orderBy('created_at', 'desc')->limit(5)->get();

        return response()->json(array(
            'games_count' => $games_count,
            'releases_count' => $releases_count,
            'developers_count' => $developers_count,
            'publishers_count' => $publishers_count,
            'genres_count' => $genres_count,
            'platform_count' => $platform_count,
            'recent_games' => $recent_games,
            'recent_users' => $recent_users,
        ), 200);
    }
}
