<?php

namespace App\Http\Controllers;

use App\Release, App\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Release::with(['game', 'platform', 'publisher', 'region', 'codeveloper', 'dateType'])
            ->orderBy('created_at', 'desc')->paginate(20);
    }

    /**
     * Display a listing of the resource for a specified game.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function gameIndex(Game $game)
    {
        return Release::with(['game', 'platform', 'publisher', 'region', 'codeveloper', 'dateType'])
        ->where('game_id', $game->id)->orderBy('created_at', 'desc')->get();
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
            'unique' => 'This release already exists',
        ];

        // Validate
        Validator::make($request->all(), [
            'game_id' => "required|unique:releases,game_id,NULL,id,platform_id,{$request->platform_id},publisher_id,{$request->publisher_id},region_id,{$request->region_id}",
            'platform_id' => 'required',
            'publisher_id' => 'required',
            'region_id' => 'required',
            'alternate_title' => 'nullable|string',
            'codeveloper_id' => 'nullable',
            'date_type_id' => 'required',
            'date' => 'nullable',
        ], $messages)->validate();

        // Create
        $release = Release::create([
            'game_id' => $request->game_id,
            'platform_id' => $request->platform_id,
            'publisher_id' => $request->publisher_id,
            'region_id' => $request->region_id,
            'alternate_title' => $request->alternate_title,
            'codeveloper_id' => $request->codeveloper_id,
            'date_type_id' => $request->date_type_id,
            'date' => $request->date,
        ]);

        return response()->json($release->load('game', 'platform', 'publisher', 'region', 'codeveloper', 'dateType'), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Release  $release
     * @return \Illuminate\Http\Response
     */
    public function show(Release $release)
    {
        return $release->load('game', 'platform', 'publisher', 'region', 'codeveloper', 'dateType');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Release  $release
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Release $release)
    {
        // Validate
        $input = $request->only('alternate_title', 'codeveloper_id', 'date_type_id', 'date');
        $this->validate($request, [
            'alternate_title' => 'nullable|string',
            'codeveloper_id' => 'nullable',
            'date_type_id' => 'required',
            'date' => 'nullable',
        ]);

        // Update
        $release->update($input);
        $release->save();

        return response()->json($release->load('game', 'platform', 'publisher', 'region', 'codeveloper', 'dateType'), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Release  $release
     * @return \Illuminate\Http\Response
     */
    public function destroy(Release $release)
    {
        $release->delete();

        return response()->json(null, 204);
    }

    /**
     * Toggle favourite.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Release  $release
     * @return \Illuminate\Http\Response
     */
    public function favourite(Request $request, Release $release)
    {
        $request->user()->toggleFavorite($release);
        $status = $request->user()->hasFavorited($release);
        
        return response()->json($status, 200);
    }
}
