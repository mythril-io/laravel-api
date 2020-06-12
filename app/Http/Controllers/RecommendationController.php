<?php

namespace App\Http\Controllers;

use App\Recommendation, App\User, App\Game;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecommendationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Recommendation::with([
            'user',
            'release' => function($q) {$q->with(['game', 'platform', 'publisher', 'codeveloper', 'dateType']);},
            'recommendedRelease' => function($q) {$q->with(['game','platform', 'publisher', 'codeveloper', 'dateType']);}
        ])->orderBy('created_at', 'desc')->paginate(8);
    }

    /**
     * Display a listing of the resource for a specified user.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function userIndex(User $user)
    {
        return Recommendation::with([
            'user',
            'release' => function($q) {$q->with(['game', 'platform', 'publisher', 'codeveloper', 'dateType']);},
            'recommendedRelease' => function($q) {$q->with(['game','platform', 'publisher', 'codeveloper', 'dateType']);}
        ])->where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(8);
    }

    /**
     * Display a listing of the resource for a specified game.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function gameIndex(Game $game)
    {
        return Recommendation::with([
            'user',
            'release' => function($q) {$q->with(['game', 'platform', 'publisher', 'codeveloper', 'dateType']);},
            'recommendedRelease' => function($q) {$q->with(['game','platform', 'publisher', 'codeveloper', 'dateType']);}
        ])->whereHas('release', function ($q) use (&$game) {
            $q->where('game_id', $game->id);
        })->orderBy('created_at', 'desc')->paginate(8);
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
            'unique' => 'This recommendation already exists',
        ];

        // Validate
        Validator::make($request->all(), [
            'release_id' => "required|unique:recommendations,release_id,NULL,id,second_release_id,{$request->second_release_id},user_id,{$request->user()->id}",            
            'second_release_id' => 'required|different:release_id',
            'content' => 'required|min: 200',
        ], $messages)->validate();

        // Create
        $recommendation = Recommendation::create([
            'user_id' => $request->user()->id,
            'release_id' => $request->release_id,
            'second_release_id' => $request->second_release_id,
            'content' => $request->content,
        ]);
        
        return response()->json($recommendation, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Recommendation  $recommendation
     * @return \Illuminate\Http\Response
     */
    public function show(Recommendation $recommendation)
    {
        return $recommendation->load([
            'user',
            'release' => function($q) {$q->with('game', 'platform', 'publisher', 'codeveloper', 'dateType');},
            'recommendedRelease' => function($q) {$q->with('game', 'platform', 'publisher', 'codeveloper', 'dateType');}
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recommendation  $recommendation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recommendation $recommendation)
    {
        // Check permission
        if($recommendation->user_id != $request->user()->id) {
            return response()->json(['message' => 'Unauthorized to edit recommendation'], 401); 
        }

        // Validate
        $input = $request->only('content');
        $this->validate($request, [
            'content' => 'required|min: 200',
        ]);

        // Update
        $recommendation->update($input);
        $recommendation->save();

        return response()->json($recommendation, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recommendation  $recommendation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Recommendation $recommendation)
    {
        // Check permission
        if($recommendation->user_id != $request->user()->id) {
            return response()->json(['message' => 'Unauthorized to delete recommendation'], 401); 
        }

        $recommendation->delete();

        return response()->json(null, 204);
    }
}
