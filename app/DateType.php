<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DateType extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'format'
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
     * The releases for the date type.
     */
    public function releases()
    {
        return $this->hasMany('App\Release');
    }
}
