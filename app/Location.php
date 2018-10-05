<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function Client()
    {
        return $this->belongsTo('App\Client');
    }
}
