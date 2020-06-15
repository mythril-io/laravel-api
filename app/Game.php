<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use Filters\Filterable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'synopsis', 'user_id', 'icon', 'banner', 'developer_id', 'score', 'library_count', 'score_rank', 'popularity_rank'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'user_id', 'developer_id'
    ];

    /**
     * The user that created this Game.
     */
    public function user()
    {
        return $this->belongsTo('App\User')
            ->select(['id','username']);
    }

    /**
     * The developer for this game.
     */
    public function developer()
    {
        return $this->belongsTo('App\Developer')
            ->select(['id','name']);
    }

    /**
     * The genres for this game.
     */
    public function genres()
    {
        return $this->belongsToMany('App\Genre');
    }

    /**
     * The releases for this game.
     */
    public function releases()
    {
        return $this->hasMany('App\Release');
    }

    /**
     * The discussions for this game.
     */
    public function discussions()
    {
        return $this->hasMany('\App\Forums\Discussion');
    }

    /**
     * The library entries for this game.
     */
    public function libraries()
    {
        return $this->hasManyThrough(Library::class, Release::class);
    }

}
