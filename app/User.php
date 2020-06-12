<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Overtrue\LaravelLike\Traits\Liker;
use Overtrue\LaravelSubscribe\Traits\Subscriber;
use Overtrue\LaravelFavorite\Traits\Favoriter;
use Overtrue\LaravelFollow\Followable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles, Liker, Subscriber, Favoriter, Followable;

    protected $guard_name ='api';
    protected $appends = ['rolenames'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'about_me', 'avatar', 'banner', 'timezone', 'birthday', 'gender', 'location', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email', 'updated_at', 'pivot', 'roles'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

    /**
     * The library entries this user has.
     */
    public function libraries()
    {
        return $this->hasMany('App\Library');
    }

    /**
     * The reviews this user has.
     */
    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    /**
     * The recommendations this user has.
     */
    public function recommendations()
    {
        return $this->hasMany('App\Recommendation');
    }

    public function getRolenamesAttribute()
    {
        return collect($this->roles)->pluck(['name'])->all();
    }
}
