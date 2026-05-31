<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'slug',
    'title',
    'content'
])]
class Page extends Model
{
    // No special casts needed for slug, title, content
}
