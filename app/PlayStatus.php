<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayStatus extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    /**
     * The library entries associated with this play status.
     */
    public function libraries()
    {
        return $this->hasMany('App\Library');
    }
}
