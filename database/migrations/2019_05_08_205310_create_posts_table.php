<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('discussion_id')->constrained('discussions');

            $table->unsignedBigInteger('parent_post_id')->nullable();
            $table->foreign('parent_post_id')->references('id')->on('posts')->onDelete('set null');
            
            $table->integer('edit_count')->unsigned()->default(0);
            $table->dateTime('hidden_at')->nullable();
            $table->unsignedBigInteger('hidden_user_id')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
