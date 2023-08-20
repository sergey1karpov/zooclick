<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $table = 'themes';

    protected $fillable = [
        'name',
        'description',
        'channel_id',
        'images',
        'is_deleted',
        'is_archive',
        'comments_active',
        'likes',
        'comments_count',
        'repost_id',
    ];
}
