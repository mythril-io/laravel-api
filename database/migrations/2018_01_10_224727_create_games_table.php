<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->text('synopsis');
            $table->string('icon');
            $table->string('banner');
            $table->foreignId('developer_id')->constrained('developers');
            $table->decimal('score', 5, 2)->unsigned()->nullable();
            $table->integer('library_count')->unsigned()->nullable();
            $table->integer('score_rank')->unsigned()->nullable();
            $table->integer('popularity_rank')->unsigned()->nullable();
            $table->integer('trending_page_views')->unsigned()->nullable();
            $table->foreignId('user_id')->constrained('users');
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
        Schema::dropIfExists('games');
    }
}
