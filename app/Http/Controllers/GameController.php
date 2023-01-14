<?php

namespace App\Http\Controllers;

use App\Game;
use App\Release;
use App\Filters\GameFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Storage;
use Intervention\Image\ImageManagerStatic as Image;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  GameFilters $filters
     * @return \Illuminate\Http\Response
     */
    public function index(GameFilters $filters)
    {
        return Game::with([
            'genres',
            'developer',
        ])->filter($filters)->orderBy('popularity_rank', 'asc')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Custom error messages
        $messages = [
            'unique' => 'This game already exists',
        ];

        // Validate
        Validator::make($request->all(), [
            'title' => 'required|unique:games',
            'synopsis' => 'required|min:10',
            'icon' => 'required|base64image|base64mimes:jpeg,png|base64dimensions:min_width=350,max_width=350,min_height=350,max_height=350|base64between:0,500',
            'banner' => 'required|base64image|base64mimes:jpeg,png|base64dimensions:min_width=1000,min_height=500|base64between:0,7000',
            'developer_id' => 'required',
            'genre_ids' => 'required',
        ], $messages)->validate();

        // Create
        $game = Game::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'synopsis' => $request->synopsis,
            'icon' => "default.png",
            'banner' => "default.png",
            'developer_id' => $request->developer_id
        ]);

        // Attach genres
        $game->genres()->sync($request->genre_ids);

        // Upload icon
        $icon = Image::make($request->get('icon'));
        $iconName = $game->id.'.'.explode('/', $icon->mime() )[1];
        Storage::put("games/icons/$iconName", (string) $icon->stream(), 'public');

        // Upload banner
        $banner = Image::make($request->get('banner'));
        $bannerName = $game->id.'.'.explode('/', $banner->mime() )[1];
        Storage::put("games/banners/$bannerName", (string) $banner->stream(), 'public');

        // Update game properties
        $game->icon = $iconName;
        $game->banner = $bannerName;
        $game->save();

        return response()->json($game->load('developer', 'genres', 'releases'), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        $game->trending_page_views += 1;
        $game->save();

        $game->load([
            'genres',
            'developer',
            'releases' => function($q) {$q->with('platform', 'publisher', 'region', 'codeveloper', 'dateType');}
        ]);

        return $game;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        // Validate
        $this->validate($request, [
            'title' => 'required|unique:games,title,'.$game->id,
            'synopsis' => 'required|min:10',
            'icon' => 'nullable|base64image|base64mimes:jpeg,png|base64dimensions:min_width=350,max_width=350,min_height=350,max_height=350|base64between:0,1000',
            'banner' => 'nullable|base64image|base64mimes:jpeg,png|base64dimensions:min_width=1000,min_height=500|base64between:0,7000',
            'developer_id' => 'required',
            'genre_ids' => 'required',
        ]);

        // Update icon
        if(!empty($request->icon)) {
            !empty($game->icon) ? Storage::delete("games/icons/$game->icon") : '';
            $icon = Image::make($request->get('icon'));
            $iconName = $game->id.'.'.explode('/', $icon->mime() )[1];
            Storage::put("games/icons/$iconName", (string) $icon->stream(), 'public');
            $game->icon = $iconName;
        }

        // Update banner
        if(!empty($request->banner)) {
            !empty($game->banner) ? Storage::delete("games/banners/$game->banner") : '';
            $banner = Image::make($request->get('banner'));
            $bannerName = $game->id.'.'.explode('/', $banner->mime() )[1];
            Storage::put("games/banners/$bannerName", (string) $banner->stream(), 'public');
            $game->banner = $bannerName;
        }

        // Update game properties
        $game->title = $request->title;
        $game->slug = Str::slug($request->title);
        $game->synopsis = $request->synopsis;
        $game->developer_id = $request->developer_id;
        $game->genres()->sync($request->genre_ids);
        $game->save();

        return response()->json($game->load('developer', 'genres', 'releases'), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {    
        Storage::delete("games/banners/$game->banner");
        Storage::delete("games/icons/$game->icon");

        $game->delete();

        return response()->json(null, 204);
    }

    /**
     * Update score, libraryCount, score_rank, popularity_rank for all games
     */
    public static function updateRatings() 
    {
      //Update score for all games
      Game::chunk(100, function ($games) {
        foreach ($games as $game) {
          $filtered = $game->libraries()->whereNotNull('score');
          $score = ($filtered->count() > 0 ? number_format(($filtered->avg('score')/10)*100, 2) : null);

          $game->update(['score' => $score]);
        }
      });

      //Update library_count for all games
      Game::withCount('libraries')->chunk(100, function ($games) {
        foreach ($games as $game) {
          $game->update(['library_count' => $game->libraries_count]);
        }
      });

      //Update score_rank for all games
      $scoreRank = 0;
      Game::orderBy('score', 'desc')->chunk(100, function ($games) use (&$scoreRank) {
        foreach ($games as $game) {
          $scoreRank++;
          $game->update(['score_rank' => $scoreRank]);
        }
      });

      //Update popularity_rank for all games
      $popularityRank = 0;
      Game::orderBy('library_count', 'desc')->chunk(100, function ($games) use (&$popularityRank) {
        foreach ($games as $game) {
          $popularityRank++;
          $game->update(['popularity_rank' => $popularityRank]);
        }
      });
    }
}
