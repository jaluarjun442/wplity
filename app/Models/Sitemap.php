<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sitemap extends Model
{
    use HasFactory;
    protected $table = "sitemap_master";
    protected $fillable = [
        'id',
        'name',
        'notes',
        'total_post_added',
        'is_submitted',
        'status'
    ];
}
