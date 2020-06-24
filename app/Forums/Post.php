<?php

namespace App\Forums;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Traits\Likeable;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use Likeable;

    protected $appends = ['has_liked', 'like_count'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body', 'discussion_id', 'user_id', 'parent_post_id', 'edit_count', 'edited_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
    ];

    /**
     * The user the post belongs to.
     *
     */
    public function user()
    {
      return $this->belongsTo('App\User', 'user_id');
    }


    /**
     * The discussion the post belongs to.
     *
     */
    public function discussion()
    {
      return $this->belongsTo('App\Forums\Discussion', 'discussion_id');
    }

    /**
     * The parent post the post has.
     *
     */
    public function parent()
    {
      return $this->belongsTo(self::class, 'parent_post_id');
    }


    /**
     * The replies the post has.
     *
     */
    public function replies()
    {
        return $this->hasMany(self::class, 'parent_post_id');
    }

    /**
     * Get user like status
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
     * Get like lount
     *
     * @return boolean
     */
    public function getLikeCountAttribute()
    {
        return $this->likers->count();
    }
}
