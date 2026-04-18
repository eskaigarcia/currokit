<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformTag extends Model
{
    protected $fillable = ['name'];

    public function contents()
    {
        return $this->belongsToMany(PlatformContent::class, 'content_tag');
    }
}
