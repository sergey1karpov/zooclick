<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Channel extends Model
{
    use HasFactory;

    protected $table = 'channels';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'image',
        'is_deleted',
        'is_archive',
        'subscribers',
    ];

    /**
     * @return HasMany
     */
    public function themes(): HasMany
    {
        return $this->hasMany(Theme::class);
    }
}
