<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $lipsum = new joshtronic\LoremIpsum();

        DB::table('users')->insert([
            [
                'username' => 'Cloud',
                'email' => 'cloud@example.com',
                'password' => Hash::make('password'),
                'avatar' => 'cloud.png',
                'banner' => 'cloud.jpg',
                'about_me' => $lipsum->paragraphs(2),
                'created_at' => \Carbon\Carbon::now()->subYears(3)->toDateTimeString(),
                'email_verified_at' => \Carbon\Carbon::now()->subYears(3)->toDateTimeString()
            ],
            [
                'username' => 'Sephiroth',
                'email' => 'sephiroth@example.com',
                'password' => Hash::make('password'),
                'avatar' => 'sephiroth.jpg',
                'banner' => 'sephiroth.jpg',
                'about_me' => $lipsum->paragraphs(2),
                'created_at' => \Carbon\Carbon::now()->subYears(3)->toDateTimeString(),
                'email_verified_at' => \Carbon\Carbon::now()->subYears(3)->toDateTimeString()
            ],
            [
                'username' => 'Balthier',
                'email' => 'balthier@example.com',
                'password' => Hash::make('password'),
                'avatar' => 'balthier.png',
                'banner' => 'balthier.jpg',
                'about_me' => $lipsum->paragraphs(2),
                'created_at' => \Carbon\Carbon::now()->subYears(3)->toDateTimeString(),
                'email_verified_at' => \Carbon\Carbon::now()->subYears(3)->toDateTimeString()
            ],            [
                'username' => 'Link',
                'email' => 'link@example.com',
                'password' => Hash::make('password'),
                'avatar' => 'link.png',
                'banner' => 'link.jpg',
                'about_me' => $lipsum->paragraphs(2),
                'created_at' => \Carbon\Carbon::now()->subYears(2)->toDateTimeString(),
                'email_verified_at' => \Carbon\Carbon::now()->subYears(2)->toDateTimeString()
            ],
            [
                'username' => 'Zelda',
                'email' => 'zelda@example.com',
                'password' => Hash::make('password'),
                'avatar' => 'zelda.png',
                'banner' => 'zelda.jpg',
                'about_me' => $lipsum->paragraphs(2),
                'created_at' => \Carbon\Carbon::now()->subYears(2)->toDateTimeString(),
                'email_verified_at' => \Carbon\Carbon::now()->subYears(2)->toDateTimeString()
            ],
            [
                'username' => 'Kratos',
                'email' => 'kratos@example.com',
                'password' => Hash::make('password'),
                'avatar' => 'kratos.png',
                'banner' => 'kratos.jpg',
                'about_me' => $lipsum->paragraphs(2),
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'email_verified_at' => \Carbon\Carbon::now()->toDateTimeString()
            ],
            [
                'username' => 'Hunter',
                'email' => 'hunter@example.com',
                'password' => Hash::make('password'),
                'avatar' => 'hunter.png',
                'banner' => 'hunter.jpg',
                'about_me' => $lipsum->paragraphs(2),
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'email_verified_at' => \Carbon\Carbon::now()->toDateTimeString()
            ],
            [
                'username' => 'Arthur',
                'email' => 'arthur@example.com',
                'password' => Hash::make('password'),
                'avatar' => 'arthur.png',
                'banner' => 'arthur.jpg',
                'about_me' => $lipsum->paragraphs(2),
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'email_verified_at' => \Carbon\Carbon::now()->toDateTimeString()
            ],
            [
                'username' => 'Joel',
                'email' => 'joel@example.com',
                'password' => Hash::make('password'),
                'avatar' => 'joel.png',
                'banner' => 'joel.jpg',
                'about_me' => $lipsum->paragraphs(2),
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'email_verified_at' => \Carbon\Carbon::now()->toDateTimeString()
            ],
            [
                'username' => 'Tracer',
                'email' => 'tracer@example.com',
                'password' => Hash::make('password'),
                'avatar' => 'tracer.png',
                'banner' => 'tracer.jpg',
                'about_me' => $lipsum->paragraphs(2),
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'email_verified_at' => \Carbon\Carbon::now()->toDateTimeString()
            ],
        ]);
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
