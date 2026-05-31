<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeyFeature extends Model
{
    protected $table = 'key_features';
    protected $fillable = ['name', 'image'];
}
