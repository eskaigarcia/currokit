<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserContentInteraction extends Model
{
    protected $fillable = ['user_id', 'platform_content_id', 'type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function content()
    {
        return $this->belongsTo(PlatformContent::class, 'platform_content_id');
    }
}
