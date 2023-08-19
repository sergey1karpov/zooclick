<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $table = 'channel';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'image',
        'is_deleted',
        'is_archive',
        'subscribers',
    ];
}
