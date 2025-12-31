<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'party_name',
        'title',
        'subtitle',
        'primary_button_text',
        'secondary_button_text',
        'stat_members',
        'stat_provinces',
        'stat_programs',
        'image_path',
        'is_active',
    ];
}
