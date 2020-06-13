<?php

namespace App\Http\Controllers;

use App\User, App\Game, App\Release;
use Illuminate\Http\Request;
use Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::orderBy('created_at', 'desc')->paginate(20);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validate
        $input = $request->only('about_me', 'timezone', 'birthday', 'gender', 'location');
        $this->validate($request, [
            'about_me' => 'string|nullable',
            'timezone' => 'timezone|nullable',
            'birthday' => 'date|nullable',
            'gender' => 'alpha|nullable',
            'location' => 'string|max: 150|nullable'
        ]);

        // Update
        $request->user()->update($input);
        $request->user()->save();

        return response()->json($request->user(), 200);
    }

    /**
     * Update avatar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAvatar(Request $request)
    {
        // Validate
        $this->validate($request, [
            'avatar' => 'nullable|base64image|base64mimes:jpeg,png|base64between:0,3000',
        ]);

        // Update
        if(!empty($request->avatar)) {
            !empty($request->user()->avatar) ? Storage::disk('s3')->delete("users/avatars/{$request->user()->avatar}") : '';
            $avatar = Image::make($request->get('avatar'));
            $avatar->resize(350, null, function ($constraint) { $constraint->aspectRatio(); });
            $avatar->encode(explode('/', $avatar->mime() )[1], 90);
            $avatarName = $request->user()->id.'.'.explode('/', $avatar->mime() )[1];
            Storage::disk('s3')->put("users/avatars/$avatarName", (string) $avatar->stream(), 'public');
            $request->user()->avatar = $avatarName;
        }

        $request->user()->save();

        return response()->json($request->user(), 200);
    }

    /**
     * Update banner.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateBanner(Request $request)
    {
        // Validate
        $this->validate($request, [
            'banner' => 'nullable|base64image|base64mimes:jpeg,png|base64between:0,6000',
        ]);

        // Update
        if(!empty($request->banner)) {
            !empty($request->user()->banner) ? Storage::disk('s3')->delete("users/banners/{$request->user()->banner}") : '';
            $banner = Image::make($request->get('banner'));
            $banner->encode(explode('/', $banner->mime() )[1], 90);
            $bannerName = $request->user()->id.'.'.explode('/', $banner->mime() )[1];
            Storage::disk('s3')->put("users/banners/$bannerName", (string) $banner->stream(), 'public');
            $request->user()->banner = $bannerName;
        }

        $request->user()->save();

        return response()->json($request->user(), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        // Validate
        $this->validate($request, [
            'password' => 'required|string|min:8'
        ]);

        // Update
        $request->user()->password = Hash::make($request->password);
        $request->user()->save();

        return response()->json(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        // Check permission
        if($user->id != $request->user()->id) {
            return response()->json(['message' => 'Unauthorized to delete'], 401); 
        }
        
        $user->delete();

        return response()->json(null, 204);
    }

    /**
     * Get followers.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function followers(User $user)
    {       
        return $user->followers()->paginate(50);
    }

    /**
     * Get following.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function following(User $user)
    {       
        return $user->followings()->paginate(50);
    }

    /**
     * Toggle follow.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function follow(Request $request, User $user)
    {
        // Check permission
        if($user->id == $request->user()->id) {
            return response()->json(['message' => 'Cannot follow self'], 401); 
        }

        $request->user()->toggleFollow($user);
        $status = $request->user()->isFollowing($user);
        
        return response()->json($status, 200);
    }

    /**
     * Toggle follow.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function followStatus(Request $request, User $user)
    {
        $status = $request->user()->isFollowing($user);
        
        return response()->json($status, 200);
    }

    /**
     * Get favourites.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function favourites(User $user)
    {
        $favourites = $user->favorites()->withType(Release::class)->with([
            'favoriteable'  => function($q) {$q->with('game', 'platform', 'publisher', 'codeveloper', 'dateType');},
        ])->get()->makeHidden(['user_id', 'favoriteable_id', 'favoriteable_type', 'updated_at', 'created_at']);  
        
        return $favourites;
    }

    /**
     * Get game favourite.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function gameFavourite(Request $request, Game $game)
    {
        $favourite = $request->user()->favorites()->withType(Release::class)->with([
            'favoriteable'  => function($q) {$q->with('platform', 'publisher', 'codeveloper', 'dateType', 'region');},
        ])->whereHasMorph('favoriteable', ['App\Release'], function ($q) use (&$game) {
            $q->where('game_id', $game->id);
        })->first();  
        
        if($favourite) {
            $favourite->makeHidden(['user_id', 'favoriteable_id', 'favoriteable_type', 'updated_at', 'created_at']);
        }

        return $favourite;
    }

    /**
     * Get game favourite and library status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function gameStatus(Request $request, Game $game)
    {
        $favourite_count = $request->user()->favorites()->withType(Release::class)->with('favoriteable')
        ->whereHasMorph('favoriteable', ['App\Release'], function ($q) use (&$game) {
            $q->where('game_id', $game->id);
        })->count();

        $library_count = $request->user()->libraries()->whereHas('release', function ($q) use (&$game) {
            $q->where('game_id', $game->id);
        })->count(); 

        $has_favourite = $favourite_count > 0 ? true : false;
        $has_library = $library_count > 0 ? true : false;

        $status = [
            'favourite' => $has_favourite,
            'library' => $has_library
        ];
        
        return response()->json($status, 200);
    }
    
}
