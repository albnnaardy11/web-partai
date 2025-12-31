<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChairpersonMessage extends Model
{
    protected $fillable = [
        'header_badge',
        'header_title',
        'image_path',
        'message_greeting',
        'message_content',
        'signature_greeting',
        'chairperson_name',
        'chairperson_title',
        'philosophy_text',
        'commitment_text',
        'is_active',
    ];}
