<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformContent extends Model
{
    protected $fillable = [
        'user_id', 'sponsor_id', 'title', 'slug', 'author',
        'excerpt', 'type', 'topic', 'views', 'likes', 'visible', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'visible' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sponsor()
    {
        return $this->belongsTo(Company::class, 'sponsor_id');
    }

    public function tags()
    {
        return $this->belongsToMany(PlatformTag::class, 'content_tag');
    }
}
