<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReleasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('releases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->foreignId('platform_id')->constrained('platforms');
            $table->foreignId('publisher_id')->constrained('publishers');
            $table->foreignId('region_id')->constrained('regions');

            $table->unsignedBigInteger('codeveloper_id')->nullable();
            $table->foreign('codeveloper_id')->references('id')->on('developers')->onDelete('set null');
            $table->unsignedBigInteger('date_type_id')->nullable();
            $table->foreign('date_type_id')->references('id')->on('date_types')->onDelete('set null');

            $table->date('date')->nullable();
            $table->string('alternate_title')->nullable();
            $table->timestamps();

            $table->unique(['game_id', 'platform_id', 'publisher_id', 'region_id', 'alternate_title'], 'gid_plid_puid_rid_at_unuiqe');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('releases');
    }
}
