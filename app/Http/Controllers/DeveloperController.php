<?php

namespace App\Http\Controllers;

use App\Developer;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Developer::orderBy('name', 'asc')->paginate(20);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return Developer::orderBy('name', 'asc')->get();
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
            'name' => 'required|unique:developers',
            'country' => 'required',
        ]);

        // Create
        $developer = Developer::create([
            'name' => $request->name,
            'country' => $request->country,
        ]);

        return response()->json($developer, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Developer  $developer
     * @return \Illuminate\Http\Response
     */
    public function show(Developer $developer)
    {
        return $developer;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Developer  $developer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Developer $developer)
    {
        // Validate
        $input = $request->only('name', 'country');
        $this->validate($request, [
            'name' => 'required|unique:developers,name,'.$id,
            'country' => 'required',
        ]);

        // Update
        $developer->update($input);
        $developer->save();

        return response()->json($developer, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Developer  $developer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Developer $developer)
    {
        $developer->delete();

        return response()->json(null, 204);
    }
}
