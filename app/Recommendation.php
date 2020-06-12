<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'release_id', 'second_release_id', 'content'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'user_id', 'release_id', 'second_release_id'
    ];

    /**
     * The user this recommendation belongs to.
     *
     */
    public function user()
    {
      return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * The release this recommendation belongs to.
     *
     */
    public function release()
    {
      return $this->belongsTo('App\Release', 'release_id');
    }

    /**
     * The second release this recommendation belongs to.
     *
     */
    public function recommendedRelease()
    {
      return $this->belongsTo('App\Release', 'second_release_id');
    }
}
