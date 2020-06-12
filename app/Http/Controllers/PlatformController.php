<?php

namespace App\Http\Controllers;

use App\Platform;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Platform::paginate(20);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return Platform::get();
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
            'name' => 'required|unique:platforms',
            'acronym' => 'nullable|string'
        ]);

        // Create
        $platform = Platform::create([
            'name' => $request->name,
            'acronym' => $request->acronym
        ]);

        return response()->json($platform, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Platform  $platform
     * @return \Illuminate\Http\Response
     */
    public function show(Platform $platform)
    {
        return $platform;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Platform  $platform
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Platform $platform)
    {
        // Validate
        $input = $request->only('name', 'acronym');
        $this->validate($request, [
            'name' => 'required|unique:platforms,name,'.$id,
            'acronym' => 'nullable|string'
        ]);

        // Update
        $platform->update($input);
        $platform->save();

        return response()->json($platform, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Platform  $platform
     * @return \Illuminate\Http\Response
     */
    public function destroy(Platform $platform)
    {
        $platform->delete();

        return response()->json(null, 204);
    }
}
