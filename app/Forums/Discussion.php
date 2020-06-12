<?php

namespace App\Forums;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Traits\Likeable;
use Overtrue\LaravelSubscribe\Traits\Subscribable;
use Illuminate\Support\Facades\Auth;

class Discussion extends Model
{
    // use Filterable;
    use Likeable, Subscribable;

    protected $appends = ['is_subscribed', 'has_liked'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title' , 'body', 'user_id', 'view_count', 'like_count', 'post_count', 'user_count', 'edited_at', 'edit_count', 'slug', 'last_posted_at', 'last_post_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id', 'posts'
    ];

    /**
     * The posts for the discussion.
     */
    public function posts()
    {
        return $this->hasMany('App\Forums\Post');
    }

   /**
    * The tags that the discussion belongs to.
    */
    public function tags()
    {
        return $this->belongsToMany('App\Forums\Tag');
    }

   /**
    * The games that the discussion belongs to.
    */
    public function games()
    {
        return $this->belongsToMany('App\Game');
    }

    /**
     * The user the discussion belongs to.
     *
     */
    public function user()
    {
      return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * The last post for the discussion.
     *
     */
    public function lastPost()
    {
      return $this->hasOne('App\Forums\Post', 'id', 'last_post_id');
    }

    /**
     * Get user subscription status
     *
     * @return boolean
     */
    public function getIsSubscribedAttribute()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return $this->isSubscribedBy($user);
        }
        return False;
    }

    /**
     * Get user like Status
     *
     * @return boolean
     */
    public function getHasLikedAttribute()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return $this->isLikedBy($user);
        }
        return False;
    }

    /**
     * Get like count
     *
     * @return boolean
     */
    public function getLikeCountAttribute()
    {
        return $this->likers->count();
    }

    /**
     * Get replies count
     *
     * @return boolean
     */
    public function getPostCountAttribute()
    {
        return $this->posts->count();
    }

    /**
     * Get unique user count
     *
     * @return boolean
     */
    public function getUserCountAttribute()
    {
        return $this->posts->groupBy('user_id')->count();
    }
}
