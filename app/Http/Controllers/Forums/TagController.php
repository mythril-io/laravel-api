<?php

namespace App\Http\Controllers\Forums;

use App\Forums\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Tag::where('is_hidden', 0)->get();
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
            'name' => 'required|unique:tags',
            'colour' => 'required',
            'order' => 'required|integer',
            'parent_id' => 'nullable|integer',
        ]);

        // Create
        $tag = Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'colour' => $request->colour,
            'order' => $request->order,
            'parent_id' => $request->parent_id,
        ]);

        return response()->json($tag, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Forums\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return $tag;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Forums\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        // Validate
        $input = $request->only('name', 'colour', 'order', 'parent_id');
        $this->validate($request, [
            'name' => 'required|unique:tags,name,'.$id,
            'colour' => 'required',
            'order' => 'required|integer',
            'parent_id' => 'nullable|integer',
        ]);

        // Update
        $tag->update($input);
        $tag->slug = Str::slug($request->name);
        $tag->save();

        return response()->json($tag, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Forums\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return response()->json(null, 204);
    }
}
