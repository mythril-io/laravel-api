<?php

namespace App\Http\Controllers\Forums;

use App\Forums\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Forums\Discussion;
use Carbon\Carbon;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Forums\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function index(Discussion $discussion)
    {
        $posts = Post::with([
            'user',
            'parent' => function($q) {$q->with([
                    'user', 
                    'parent' => function($q) {$q->with(['user']);}  
                ]);},
            'replies' => function($q) {$q->with(['user']);}
          ])->where('discussion_id', $discussion->id)->paginate(25);

        $num = ($posts->currentPage() - 1) * $posts->perPage() + 1;

        foreach($posts as $post) {
            $post->num = $num++;
        }

        return $posts;
    }

    /**
     * Find the page the post is located for the discussion it belongs to.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function find(Post $post) {
        
        $position= Post::where([
            ['id', '<=', $post->id],
            ['discussion_id', '=', $post->discussion_id],
        ])->count();

        $page = ceil($position/25);

        return $page;

        // $posts = Post::with([
        //     'user',
        //     'parent' => function($q) {$q->with([
        //             'user', 
        //             'parent' => function($q) {$q->with(['user']);}  
        //         ]);},
        //     'replies' => function($q) {$q->with(['user']);}
        //   ])->where('discussion_id', $post->discussion_id)->paginate(25, ['*'], 'page', $page);

        // $num = ($posts->currentPage() - 1) * $posts->perPage() + 1;

        // foreach($posts as $post) {
        //     $post->num = $num++;
        // }

        // return $posts;        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Forums\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Discussion $discussion)
    {
        // Validate
        $this->validate($request, [
            'body' => 'required|string|min: 10',
            'parent_post_id' => 'nullable|numeric',
        ]);

        // Create
        $post = Post::create([
            'user_id' => $request->user()->id,
            'discussion_id' => $discussion->id,
            'body' => $request->body,
            'parent_post_id' => $request->parent_post_id,
        ]);
        
        // Update discussion metainfo
        $discussion->increment('post_count', 1);
        $discussion->user_count = $discussion->posts->groupBy('user_id')->count();
        $discussion->last_post_id = $post->id;
        $discussion->last_posted_at = $post->created_at;
        $discussion->save();
        
        // Load post relationships
        $post->load([
            'user',
            'parent' => function($q) {$q->with([
                    'user', 
                    'parent' => function($q) {$q->with(['user']);}  
                ]);},
        ]);

        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Forums\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return $post->load([
            'user',
            'parent' => function($q) {$q->with([
                    'user', 
                    'parent' => function($q) {$q->with(['user']);}  
                ]);},
            'replies' => function($q) {$q->with(['user']);}
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Forums\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // Check permission
        if($post->user_id != $request->user()->id) {
            return response()->json(['message' => 'Unauthorized to edit post'], 401); 
        }

        // Validate
        $this->validate($request, [
            'body' => 'required|string|min: 10',
        ]);

        // Update
        $post->body = $request->body;
        $post->edit_count++;
        $post->edited_at = Carbon::now()->toDateTimeString();
        $post->save();

        return response()->json($post, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Forums\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // Check permission
        if($post->user_id != $request->user()->id) {
            return response()->json(['message' => 'Unauthorized to delete post'], 401); 
        }
        
        $post->delete();

        return response()->json(null, 204);
    }

    /**
     * Toggle like.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Forums\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function like(Request $request, Post $post)
    {
        $request->user()->toggleLike($post);
        $status = $request->user()->hasLiked($post);
        
        return response()->json($status, 200);
    }
}
