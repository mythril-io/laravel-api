<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'game_id', 'release_id', 'play_status_id', 'score', 'own', 'digital', 'hours', 'notes'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'play_status_id', 'user_id', 'release_id'
    ];

    /**
     * The user this library entry belongs to.
     *
     */
    public function user()
    {
      return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * The release this library entry belongs to.
     *
     */
    public function release()
    {
      return $this->belongsTo('App\Release', 'release_id');
    }

    /**
     * The play status this library entry belongs to.
     *
     */
    public function playStatus()
    {
      return $this->belongsTo('App\PlayStatus', 'play_status_id');
    }
}
