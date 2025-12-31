<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    protected $fillable = [
        'header_badge',
        'header_title',
        'header_description',
        'feature_1_title',
        'feature_1_description',
        'feature_2_title',
        'feature_2_description',
        'feature_3_title',
        'feature_3_description',
        'banner_title',
        'banner_description',
        'is_active',
    ];}
