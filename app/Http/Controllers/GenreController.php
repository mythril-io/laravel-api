<?php

namespace App\Http\Controllers;

use App\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Genre::orderBy('name', 'asc')->paginate(20);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return Genre::orderBy('name', 'asc')->get();
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
            'name' => 'required|unique:genres',
            'acronym' => 'nullable|string'
        ]);

        // Create
        $genre = Genre::create([
            'name' => $request->name,
            'acronym' => $request->acronym
        ]);

        return response()->json($genre, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function show(Genre $genre)
    {
        return $genre;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genre $genre)
    {
        // Validate
        $input = $request->only('name', 'acronym');
        $this->validate($request, [
            'name' => 'required|unique:genres,name,'.$genre->id,
            'acronym' => 'nullable|string'
        ]);

        // Update
        $genre->update($input);
        $genre->save();

        return response()->json($genre, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();

        return response()->json(null, 204);
    }
}
