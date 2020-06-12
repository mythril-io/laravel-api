<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // protected $appends = ['like_count', 'dislike_count'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'release_id', 'summary', 'content', 'score'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'release_id', 'user_id',
    ];

    /**
     * The user this review belongs to.
     *
     */
    public function user()
    {
      return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * The release this review belongs to.
     *
     */
    public function release()
    {
      return $this->belongsTo('App\Release', 'release_id');
    }

    /**
     * The date type this review belongs to.
     *
     */
    public function dateType()
    {
        return $this->belongsTo('App\DateType', 'date_type_id')
            ->select(['id','format']);
    }

    // /**
    //  * The number of Likes this Review has
    //  *
    //  * @return Int
    //  */
    // public function getLikeCountAttribute()
    // {
    //     return $this->upvoters->count();
    // }

    // /**
    //  * The number of Dislikes this Review has
    //  *
    //  * @return Int
    //  */
    // public function getDislikeCountAttribute()
    // {
    //     return $this->downvoters->count();
    // }
}
