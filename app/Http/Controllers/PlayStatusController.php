<?php

namespace App\Http\Controllers;

use App\PlayStatus;
use Illuminate\Http\Request;

class PlayStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PlayStatus::paginate(20);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return PlayStatus::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate
        $this->validate($request, [
            'name' => 'required|unique:play_statuses',
        ]);

        // Create
        $playStatus = PlayStatus::create([
            'name' => $request->name,
        ]);

        return response()->json($playStatus, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PlayStatus  $playStatus
     * @return \Illuminate\Http\Response
     */
    public function show(PlayStatus $playStatus)
    {
        return $playStatus;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PlayStatus  $playStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlayStatus $playStatus)
    {
        // Validate
        $input = $request->only('name');
        $this->validate($request, [
            'name' => 'required|unique:play_statuses,name,'.$playStatus->id,
        ]);

        // Update
        $playStatus->update($input);
        $playStatus->save();

        return response()->json($playStatus, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PlayStatus  $playStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlayStatus $playStatus)
    {
        $playStatus->delete();

        return response()->json(null, 204);
    }
}
