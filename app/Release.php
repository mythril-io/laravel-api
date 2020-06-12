<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;

class Release extends Model
{
    use Favoriteable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id', 'platform_id', 'publisher_id', 'codeveloper_id', 'alternate_title',
        'region_id', 'date', 'date_type_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'platform_id', 'publisher_id', 'codeveloper_id', 'game_id', 'date_type_id', 'region_id'
    ];

    /**
     * The game this release belongs to.
     *
     */
    public function game()
    {
        return $this->belongsTo('App\Game', 'game_id');
    }

    /**
     * The platform this release belongs to.
     *
     */
    public function platform()
    {
        return $this->belongsTo('App\Platform', 'platform_id');
    }

    /**
     * The co-developer this release belongs to.
     *
     */
    public function codeveloper()
    {
        return $this->belongsTo('App\Developer', 'codeveloper_id')
            ->select(['id','name']);
    }

    /**
     * The publisher this release belongs to.
     *
     */
    public function publisher()
    {
        return $this->belongsTo('App\Publisher', 'publisher_id')
            ->select(['id','name']);
    }

    /**
     * The region this release belongs to.
     *
     */
    public function region()
    {
        return $this->belongsTo('App\Region', 'region_id')
            ->select(['id', 'name', 'acronym']);
    }

    /**
     * The date type this release belongs to.
     *
     */
    public function dateType()
    {
        return $this->belongsTo('App\DateType', 'date_type_id')
            ->select(['id','format']);
    }

    /**
     * The library entries this release has.
     */
    public function libraries()
    {
        return $this->hasMany('App\Library');
    }

    /**
     * The reviews this release has.
     */
    public function reviews()
    {
        return $this->hasMany('App\Review');
    }
}
