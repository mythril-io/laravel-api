<?php

namespace App\Http\Controllers;

use App\Library, App\User, App\PlayStatus, App\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Library::with([
            'user',
            'playStatus',
            'release' => function($q) {$q->with('game', 'platform', 'publisher', 'codeveloper', 'dateType');}
        ])->orderBy('created_at', 'desc')->paginate(20);
    }

    /**
     * Get recent libraries by game.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function recentGameIndex(Game $game)
    {
        return Library::with([
            'playStatus',
            'user',
            'release'  => function($q) {$q->with('platform', 'publisher', 'region', 'codeveloper', 'dateType');},
        ])->whereHas('release', function ($q) use (&$game) {
            $q->where('game_id', $game->id);
        })->paginate(4);  
    }

    /**
     * Get libraries by user and play status.
     *
     * @param  \App\User  $user
     * @param  \App\PlayStatus  $status
     * @return \Illuminate\Http\Response
     */
    public function userAndStatusIndex(User $user, PlayStatus $status)
    {
        return $user->libraries()->with([
            'playStatus',
            'release'  => function($q) {$q->with('game', 'platform', 'publisher', 'region', 'codeveloper', 'dateType');},
        ])->where('play_status_id', $status->id)->paginate(20);          
    }

    /**
     * Get libraries by user and game.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function userAndGameIndex(Request $request, Game $game)
    {
        return $request->user()->libraries()->with([
            'playStatus',
            'release'  => function($q) {$q->with('platform', 'publisher', 'region', 'codeveloper', 'dateType');},
        ])->whereHas('release', function ($q) use (&$game) {
            $q->where('game_id', $game->id);
        })->get();  
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
            'unique' => 'This library entry already exists',
        ];

        // Validate
        Validator::make($request->all(), [
            'release_id' => "required|unique:libraries,release_id,NULL,id,user_id,{$request->user()->id}",            
            'play_status_id' => 'required|numeric|min:1',
            'own' => 'boolean',
            'digital' => 'boolean',
            'score' => 'nullable|digits_between:1,10',
            'hours' => 'nullable|numeric|min:1',
            'notes' => 'nullable'
        ], $messages)->validate();

        // Create
        $entry = Library::create([
            'user_id' => $request->user()->id,
            'release_id' => $request->release_id,
            'play_status_id' => $request->play_status_id,
            'score' => $request->score,
            'own' => $request->own,
            'digital' => $request->digital,
            'hours' => $request->hours,
            'notes' => $request->notes
        ]);
        
        // Load relationships
        $entry->load([
            'playStatus',
            'release' => function($q) {$q->with('platform', 'publisher', 'codeveloper', 'region', 'dateType');}
        ]);

        return response()->json($entry, 201);     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function show(Library $library)
    {
        return $library->load([
            'user',
            'playStatus',
            'release' => function($q) {$q->with('game', 'platform', 'publisher', 'codeveloper', 'dateType');}
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Library $library)
    {
        // Check permission
        if($library->user_id != $request->user()->id) {
            return response()->json(['message' => 'Unauthorized to edit library entry'], 401); 
        }

        // Validate
        $input = $request->only('play_status_id', 'own', 'digital', 'score', 'hours', 'notes');
        $this->validate($request, [
            'play_status_id' => 'required|numeric|min:1',
            'own' => 'boolean',
            'digital' => 'boolean',
            'score' => 'nullable|digits_between:1,10',
            'hours' => 'nullable|numeric|min:1',
            'notes' => 'nullable'
        ]);

        // Update
        $library->update($input);
        $library->save();

        // Load relationships
        $library->load([
            'playStatus',
            'release' => function($q) {$q->with('platform', 'publisher', 'codeveloper', 'region', 'dateType');}
        ]);

        return response()->json($library, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Library $library)
    {
        // Check permission
        if($library->user_id != $request->user()->id) {
            return response()->json(['message' => 'Unauthorized to delete library entry'], 401); 
        }
        
        $library->delete();

        return response()->json(null, 204);
    }
}
