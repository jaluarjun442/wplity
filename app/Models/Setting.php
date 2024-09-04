<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = "setting";
    protected $fillable = [
        'id',
        'site_name',
        'site_url',
        'site_logo',
        'site_type',
        'default_site_id',
        'header_script',
        'footer_script',
        'header_style',
        'ads',
        'status',
        'ad_redirect',
        'ad_redirect_seconds',
        'ad_redirect_url'
    ];
}
