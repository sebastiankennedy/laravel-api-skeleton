<?php

namespace App\Models;

use App\Behaviors\BeLikedBehavior;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use BeLikedBehavior;

    protected $guarded = [];
}
