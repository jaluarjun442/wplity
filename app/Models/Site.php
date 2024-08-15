<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;
    protected $table = "site_master";
    protected $fillable = [
        'id',
        'name',
        'description',
        'last_id',
        'total_post',
        'url',
        'status',
        'image',
        'last_updated_fetch',
        'last_updated_api_send',
        'api_send_url',
        'thumbnail_display',
        'category',
        'category_display'
    ];
}
