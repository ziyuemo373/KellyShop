<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{

    protected $fillable = [
        'name', 'email', 'password', 'status',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
