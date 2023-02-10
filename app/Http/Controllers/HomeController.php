<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game, App\Release, App\User, App\Review, App\Recommendation, App\Library;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Featured games.
     *
     * @return \Illuminate\Http\Response
     */
    public function featured()
    {
        return Game::with('genres', 'developer')->where('title', 'Elden Ring')->first();
    }

    /**
     * Trending games.
     *
     * @return \Illuminate\Http\Response
     */
    public function trending()
    {
        return Game::with('genres', 'developer')->orderBy('trending_page_views', 'desc')->orderByRaw('-popularity_rank desc')->limit(6)->get();
    }

    /**
     * Recent user review.
     *
     * @return \Illuminate\Http\Response
     */
    public function recentUserReview()
    {
        return Review::with([
            'user',
            'release' => function($q) {$q->with('game', 'platform', 'publisher', 'codeveloper', 'dateType');}
        ])->orderBy('created_at', 'desc')->limit(1)->get()[0];
    }

    /**
     * Recent user recommendation.
     *
     * @return \Illuminate\Http\Response
     */
    public function recentUserRecommendation()
    {
        return Recommendation::with([
            'user',
            'release' => function($q) {$q->with(['game', 'platform', 'publisher', 'codeveloper', 'dateType']);},
            'recommendedRelease' => function($q) {$q->with(['game','platform', 'publisher', 'codeveloper', 'dateType']);}
        ])->orderBy('created_at', 'desc')->limit(1)->get()[0];
    }

    /**
     * Stats.
     *
     * @return \Illuminate\Http\Response
     */
    public function stats()
    {
        $games_count = Game::all()->count();
        $releases_count = Release::all()->count();
        $users_count = User::all()->count();
        $reviews_count = Review::all()->count();
        $recommendations_count = Recommendation::all()->count();

        return response()->json(array(
            'games' => $games_count,
            'releases' => $releases_count,
            'users' => $users_count,
            'reviews' => $reviews_count,
            'recommendations' => $recommendations_count,
        ), 200);
    }

    /**
     * Recent user activity.
     *
     * @return \Illuminate\Http\Response
     */
    public function recentUserActivity()
    {
        return Library::with([
            'user',
            'playStatus',
            'release' => function($q) {$q->with('game', 'platform', 'publisher', 'codeveloper', 'dateType');}
        ])->orderBy('created_at', 'desc')->limit(6)->get();
    }
}
