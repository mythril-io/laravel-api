<?php

namespace App\Http\Controllers;

use App\Review, App\User, App\Game;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Review::with([
            'user',
            'release' => function($q) {$q->with('game', 'platform', 'publisher', 'codeveloper', 'dateType');}
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
        return Review::with([
            'user',
            'release' => function($q) {$q->with('game', 'platform', 'publisher', 'codeveloper', 'dateType');}
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
        return Review::with([
            'user',
            'release' => function($q) {$q->with('game', 'platform', 'publisher', 'codeveloper', 'dateType');}
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
            'unique' => 'This review already exists',
        ];

        // Validate
        Validator::make($request->all(), [
            'release_id' => "required|unique:reviews,release_id,NULL,id,user_id,{$request->user()->id}",            
            'summary' => 'required|min: 60|max: 255',
            'content' => 'required|min: 500',
            'score' => 'numeric|between:1,100|required'
        ], $messages)->validate();

        // Create
        $review = Review::create([
            'user_id' => $request->user()->id,
            'release_id' => $request->release_id,
            'summary' => $request->summary,
            'content' => $request->content,
            'score' => $request->score
        ]);
        
        return response()->json($review, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        return $review->load([
            'user',
            'release' => function($q) {$q->with('game', 'platform', 'publisher', 'codeveloper', 'dateType');}
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        // Check permission
        if($review->user_id != $request->user()->id) {
            return response()->json(['message' => 'Unauthorized to edit review'], 401); 
        }

        // Validate
        $input = $request->only('summary', 'content');
        $this->validate($request, [
            'summary' => 'required|min: 60|max: 255',
            'content' => 'required|min: 500',
        ]);

        // Update
        $review->update($input);
        $review->save();

        return response()->json($review, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Review $review)
    {
        // Check permission
        if($review->user_id != $request->user()->id) {
            return response()->json(['message' => 'Unauthorized to delete review'], 401); 
        }
        
        $review->delete();

        return response()->json(null, 204);
    }
}
