<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Vote extends Model
{
    protected $fillable = [
        'user_id', 'location_id', 'vote'
    ];
}