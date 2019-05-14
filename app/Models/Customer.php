<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    protected $table = 'customers';

    protected $fillable = ['first_name', 'last_name', 'gender', 'date_of_birth', 'email', 'password', 'subscribed_to_news_letter', 'is_verified', 'token'];

    protected $hidden = ['password', 'remember_token'];

    public function getNameAttribute() {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }
}
