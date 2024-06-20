<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "description",
        "punctuation",
        "creation_date",
        "content_id",
        "user_id"
    ];
}
