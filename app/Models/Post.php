<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = "post_master";
    protected $fillable = [
        'id',
        'site_id',
        'post_id',
        'slug',
        'sitemap_added',
        'status'
    ];
}
