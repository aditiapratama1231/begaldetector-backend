<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Location extends Model
{
    protected $fillable = [
        'user_id','city','lat','lng','information',
    ];


    public function user(){
        return $this->belongsTo('App\User');
    }
}
