<?php

namespace App\Http\Controllers\Forums;

use App\Forums\Discussion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  string  $tag
     * @return \Illuminate\Http\Response
     */
    public function index($tag = NULL)
    {
        return Discussion::with([
            'user',
            'tags' => function($q) {$q->select('id', 'name', 'slug', 'colour');},
            'games',
            'lastPost' => function($q) {$q->with(['user']);}
        ])->when($tag, function ($query, $tag) {
            return $query->whereHas('tags', function ($query) use ($tag) {
                    $query->where('slug', '=', $tag);
                });
        })->orderBy('last_posted_at', 'desc')->paginate(15);
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
            'title' => 'required|string|min: 10',
            'body' => 'required|string|min: 10',
            'tag_ids' => 'required'
        ]);

        // Create
        $discussion = Discussion::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'body' => $request->body,
            'slug' => Str::slug($request->title),
            'last_posted_at' => Carbon::now()->toDateTimeString()
        ]);

        $discussion->tags()->sync($request->tag_ids);
        $request->game_ids ? $discussion->games()->sync($request->game_ids) : '';

        return response()->json($discussion->load('user', 'tags', 'games'), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Forums\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function show(Discussion $discussion)
    {
        return $discussion->load([
            'user',
            'tags' => function($q) {$q->select('id', 'name', 'slug', 'colour');},
            'games'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Forums\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discussion $discussion)
    {
        // Check permission
        if($discussion->user_id != $request->user()->id) {
            return response()->json(['message' => 'Unauthorized to edit discussion'], 401); 
        }

        // Validate
        $this->validate($request, [
            'body' => 'required|string|min: 10',
        ]);

        // Update
        $discussion->body = $request->body;
        $discussion->edit_count++;
        $discussion->edited_at = Carbon::now()->toDateTimeString();
        $discussion->save();

        return response()->json($discussion, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Forums\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discussion $discussion)
    {
        // Check permission
        if($discussion->user_id != $request->user()->id) {
            return response()->json(['message' => 'Unauthorized to delete discussion'], 401); 
        }
        
        $discussion->delete();

        return response()->json(null, 204);
    }

    /**
     * Toggle like.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Forums\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function like(Request $request, Discussion $discussion)
    {
        $request->user()->toggleLike($discussion);
        $status = $request->user()->hasLiked($discussion);
        
        return response()->json($status, 200);
    }

    /**
     * Toggle subscribe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Forums\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request, Discussion $discussion)
    {
        $request->user()->toggleSubscribe($discussion);
        $status = $request->user()->hasSubscribed($discussion);
        
        return response()->json($status, 200);
    }
}
