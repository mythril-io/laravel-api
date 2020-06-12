<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLibrariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('libraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('release_id')->constrained('releases')->onDelete('cascade');
            $table->foreignId('play_status_id')->constrained('play_statuses');
            $table->tinyInteger('score')->unsigned()->nullable();
            $table->boolean('own')->default(true);
            $table->boolean('digital')->default(false);
            $table->integer('hours')->unsigned()->nullable();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('libraries');
    }
}
