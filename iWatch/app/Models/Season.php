<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "season_name",
        "order",
        "content_id",
        "categoria_id"
    ];
}
