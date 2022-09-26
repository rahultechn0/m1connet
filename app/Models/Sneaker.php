<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Sneaker extends Model
{
    use HasFactory,HasApiTokens;
    protected $fillable = [
        'user_id', 'trans_id', 'name','level', 'color', 'rarity', '	time_type','charisma'
    ];
}
