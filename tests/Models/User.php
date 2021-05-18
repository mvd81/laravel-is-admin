<?php

namespace Mvd81\LaravelIsAdmin\Test\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Mvd81\LaravelIsAdmin\Traits\isAdmin;

class User extends Authenticatable
{
    use isAdmin;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
