<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name', 'surname', 'fatherName', 'email', 'phone', 'country', 'state', 'city', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function locations()
    {
        return $this->hasMany('App\Location');
    }
}
