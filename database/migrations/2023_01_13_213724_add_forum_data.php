<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\User;
use App\Game;
use App\Forums\Discussion;
use App\Forums\Post;
use App\Forums\Tag;
use Carbon\Carbon;

class AddForumData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $lipsum = new joshtronic\LoremIpsum();

        // Create Discussion
        $title = $lipsum->words(6);
        $discussion = Discussion::create([
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => $lipsum->paragraphs(2),
            'user_id' => User::firstWhere('username', 'Cloud')->id,
            'last_posted_at' => Carbon::now()->toDateTimeString(),
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        // Add Tags
        $discussion->tags()->sync([Tag::firstWhere('name','Games')->id,Tag::firstWhere('name','Release Discussion')->id]);
        $discussion->games()->sync([Game::firstWhere('title','Final Fantasy VII Remake')->id, Game::firstWhere('title','Final Fantasy VII')->id,]);

        // Create Post
        $post = Post::create([
            'user_id' => User::firstWhere('username', 'Sephiroth')->id,
            'discussion_id' => $discussion->id,
            'body' => $lipsum->paragraphs(1),
        ]);

        $secondPost = Post::create([
            'user_id' => User::firstWhere('username', 'Cloud')->id,
            'discussion_id' => $discussion->id,
            'body' => $lipsum->paragraphs(1),
            'parent_post_id' => $post->id,
        ]);

        $lastPost = Post::create([
            'user_id' => User::firstWhere('username', 'Balthier')->id,
            'discussion_id' => $discussion->id,
            'body' => $lipsum->paragraphs(2),
            'parent_post_id' => $post->id,
        ]);
        
        // Update discussion metainfo
        $discussion->increment('post_count', 2);
        $discussion->user_count = $discussion->posts->groupBy('user_id')->count();
        $discussion->last_post_id = $lastPost->id;
        $discussion->last_posted_at = $lastPost->created_at;
        $discussion->save();


        // Create Discussion
        $title = $lipsum->words(8);
        $discussion = Discussion::create([
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => $lipsum->paragraphs(3),
            'user_id' => User::firstWhere('username', 'Hunter')->id,
            'last_posted_at' => Carbon::now()->toDateTimeString(),
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        // Add Tags
        $discussion->tags()->sync([Tag::firstWhere('name','General')->id]);

        // Create Post
        $post = Post::create([
            'user_id' => User::firstWhere('username', 'Zelda')->id,
            'discussion_id' => $discussion->id,
            'body' => $lipsum->paragraphs(1),
        ]);

        $secondPost = Post::create([
            'user_id' => User::firstWhere('username', 'Hunter')->id,
            'discussion_id' => $discussion->id,
            'body' => $lipsum->paragraphs(2),
            'parent_post_id' => $post->id,
        ]);

        $thirdPost = Post::create([
            'user_id' => User::firstWhere('username', 'Link')->id,
            'discussion_id' => $discussion->id,
            'body' => $lipsum->paragraphs(2),
            'parent_post_id' => $secondPost->id,
        ]);

        $fourthPost = Post::create([
            'user_id' => User::firstWhere('username', 'Sephiroth')->id,
            'discussion_id' => $discussion->id,
            'body' => $lipsum->paragraphs(1),
            'parent_post_id' => $secondPost->id,
        ]);

        $lastPost = Post::create([
            'user_id' => User::firstWhere('username', 'Hunter')->id,
            'discussion_id' => $discussion->id,
            'body' => $lipsum->paragraphs(2),
        ]);
        
        // Update discussion metainfo
        $discussion->increment('post_count', 4);
        $discussion->user_count = $discussion->posts->groupBy('user_id')->count();
        $discussion->last_post_id = $lastPost->id;
        $discussion->last_posted_at = $lastPost->created_at;
        $discussion->save();

        // Create Discussion
        $title = $lipsum->words(5);
        $discussion = Discussion::create([
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => $lipsum->paragraphs(1),
            'user_id' => User::firstWhere('username', 'Tracer')->id,
            'last_posted_at' => Carbon::now()->toDateTimeString(),
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        // Add Tags
        $discussion->tags()->sync([Tag::firstWhere('name','Anime')->id]);

        // Create Post
        $post = Post::create([
            'user_id' => User::firstWhere('username', 'Balthier')->id,
            'discussion_id' => $discussion->id,
            'body' => $lipsum->paragraphs(1),
        ]);

        $secondPost = Post::create([
            'user_id' => User::firstWhere('username', 'Zelda')->id,
            'discussion_id' => $discussion->id,
            'body' => $lipsum->paragraphs(2),
            'parent_post_id' => $post->id,
        ]);

        $lastPost = Post::create([
            'user_id' => User::firstWhere('username', 'Tracer')->id,
            'discussion_id' => $discussion->id,
            'body' => $lipsum->paragraphs(1),
        ]);
        
        // Update discussion metainfo
        $discussion->increment('post_count', 3);
        $discussion->user_count = $discussion->posts->groupBy('user_id')->count();
        $discussion->last_post_id = $lastPost->id;
        $discussion->last_posted_at = $lastPost->created_at;
        $discussion->save();

        // 'like_count'
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
