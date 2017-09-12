<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Location extends Model
{
    public function user(){
        return $this->belongsTo('User', 'user_id');
    }
}
