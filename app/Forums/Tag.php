<?php

namespace App\Forums;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name' , 'colour', 'order', 'parent_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'pivot', 'parent_id', 'last_posted_discussion_id', 'last_posted_user_id'
    ];

    /**
     * The discussions for the tag.
     */
    public function discussions()
    {
        return $this->hasMany('App\Forums\Discussion');
    }
}
