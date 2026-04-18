<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAchievement extends Model
{
    public $timestamps = false;

    protected $table = 'users_achievements';

    protected $fillable = ['user_id', 'achievement_id', 'obtained_at'];

    protected function casts(): array
    {
        return ['obtained_at' => 'datetime'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function achievement()
    {
        return $this->belongsTo(Achievement::class);
    }
}
