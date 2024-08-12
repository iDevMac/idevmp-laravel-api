<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qppoint extends Model
{
    use HasFactory;

    protected $fillable = [
        "video_id",
        "progress",
        "percentage",
        "active"
    ];
}
