<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'username', 'password', 'gender', 'country', 'city', 'phone'
    ];

    protected $appends = ['full_name'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }
}