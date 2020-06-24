<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/users/session-user', function (Request $request) {
    return $request->user();
});


/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('home/featured', 'HomeController@featured');
Route::get('home/trending', 'HomeController@trending');
Route::get('home/user-review', 'HomeController@recentUserReview');
Route::get('home/user-recommendation', 'HomeController@recentUserRecommendation');
Route::get('home/stats', 'HomeController@stats');
Route::get('home/user-activity', 'HomeController@recentUserActivity');

// Games
Route::get('games', 'GameController@index');
Route::get('games/{game}', 'GameController@show');

// Reviews
Route::get('reviews', 'ReviewController@index');
Route::get('reviews/user/{user}', 'ReviewController@userIndex');
Route::get('reviews/game/{game}', 'ReviewController@gameIndex');
Route::get('reviews/{review}', 'ReviewController@show');

// Recommendations
Route::get('recommendations', 'RecommendationController@index');
Route::get('recommendations/{recommendation}', 'RecommendationController@show');

Route::get('recommendations/user/{user}', 'RecommendationController@userIndex');
Route::get('recommendations/game/{game}', 'RecommendationController@gameIndex');

// Releases
Route::get('releases', 'ReleaseController@index');
Route::get('releases/{release}', 'ReleaseController@show');
Route::get('releases/game/{game}', 'ReleaseController@gameIndex');

// Libraries
Route::get('libraries', 'LibraryController@index');
Route::get('libraries/{library}', 'LibraryController@show');

Route::get('libraries/game/{game}/recent', 'LibraryController@recentGameIndex');
Route::get('libraries/user/{user}/status/{status}', 'LibraryController@userAndStatusIndex');

// Users
Route::get('users', 'UserController@index');
Route::get('users/{user}', 'UserController@show');
Route::get('users/{user}/following', 'UserController@following');
Route::get('users/{user}/followers', 'UserController@followers');
Route::get('users/{user}/favourites', 'UserController@favourites');

// Forum Discussions
Route::get('forums/{tag?}', 'Forums\DiscussionController@index' );
Route::get('forums/discussions/{discussion}', 'Forums\DiscussionController@show');

// Forum Posts
Route::get('forums/discussions/{discussion}/posts', 'Forums\PostController@index');
Route::get('forums/posts/{post}/find', 'Forums\PostController@find');

// Forum Tags
Route::get('forums/tags/all', 'Forums\TagController@index');

// Misc
Route::get('platforms/all', 'PlatformController@all');
Route::get('genres/all', 'GenreController@all');
Route::get('developers/all', 'DeveloperController@all');
Route::get('publishers/all', 'PublisherController@all');
Route::get('playstatuses/all', 'PlayStatusController@all');
Route::get('datetypes/all', 'DateTypeController@all');
Route::get('regions/all', 'RegionController@all');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::group([
    'middleware' => ['auth:sanctum'],
], function ($router) {

    // Games
    Route::get('games/{game}/user-status', 'GameController@userStatus');

    // Reviews
    Route::post('reviews', 'ReviewController@store');
    Route::patch('reviews/{review}', 'ReviewController@update');
    Route::delete('reviews/{review}', 'ReviewController@destroy');

    // Recommendations
    Route::post('recommendations', 'RecommendationController@store');
    Route::patch('recommendations/{recommendation}', 'RecommendationController@update');
    Route::delete('recommendations/{recommendation}', 'RecommendationController@destroy');

    // Releases
    Route::post('releases/{release}/favourite', 'ReleaseController@favourite');
    Route::delete('releases/{release}/favourite', 'ReleaseController@favourite');

    // Library
    Route::post('libraries', 'LibraryController@store');
    Route::patch('libraries/{library}', 'LibraryController@update');
    Route::delete('libraries/{library}', 'LibraryController@destroy');
    Route::get('libraries/game/{game}', 'LibraryController@userAndGameIndex');

    // Users
    Route::patch('users/update', 'UserController@update');
    Route::patch('users/avatar', 'UserController@updateAvatar');
    Route::patch('users/banner', 'UserController@updateBanner');
    Route::patch('users/password', 'UserController@updatePassword');
    Route::post('users/{user}/follow', 'UserController@follow');
    Route::get('users/{user}/follow-status', 'UserController@followStatus');
    Route::get('users/game/{game}/favourite', 'UserController@gameFavourite');
    Route::get('users/game/{game}/status', 'UserController@gameStatus');

    // Forum Discussions
    Route::post('forums/discussions', 'Forums\DiscussionController@store' );
    Route::patch('forums/discussions/{discussion}', 'Forums\DiscussionController@update');
    Route::post('forums/discussions/{discussion}/like', 'Forums\DiscussionController@like');
    Route::post('forums/discussions/{discussion}/subscribe', 'Forums\DiscussionController@subscribe');

    // Forum Posts
    Route::post('forums/discussions/{discussion}', 'Forums\PostController@store');
    Route::patch('forums/posts/{post}', 'Forums\PostController@update');
    Route::post('forums/posts/{post}/like', 'Forums\PostController@like');

});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::group([
    'middleware' => ['auth:sanctum', 'role:admin'],
], function ($router) {

    // Games
    Route::post('games', 'GameController@store');
    Route::put('games/{game}', 'GameController@update');
    Route::delete('games/{game}', 'GameController@destroy');

    // Releases
    Route::post('releases', 'ReleaseController@store');
    Route::patch('releases/{release}', 'ReleaseController@update');
    Route::delete('releases/{release}', 'ReleaseController@destroy');

});