<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Reward extends Model
{
    use HasFactory,HasApiTokens;
    protected $fillable = [
        'user_id', 'sneaker_id','distance','reward'
    ];
}
