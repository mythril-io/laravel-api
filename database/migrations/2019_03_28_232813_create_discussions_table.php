<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('slug')->unique();
            $table->text('body');
            $table->foreignId('user_id')->constrained('users');
            
            $table->integer('view_count')->unsigned()->default(0)->index();
            $table->integer('like_count')->unsigned()->default(0)->index();
            $table->integer('post_count')->unsigned()->default(0)->index();
            $table->integer('user_count')->unsigned()->default(0)->index();
            $table->integer('edit_count')->unsigned()->default(0);
            $table->dateTime('edited_at')->nullable();

            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_locked')->default(false);

            $table->unsignedBigInteger('last_post_id')->nullable()->index();
            $table->dateTime('last_posted_at')->nullable()->index();

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
        Schema::dropIfExists('discussions');
    }
}
