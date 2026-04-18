<?php

namespace App\Models;

use App\Enums\RewardType;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = [
        'title', 'description', 'icon',
        'reward_type', 'reward_value', 'level_points',
    ];

    protected function casts(): array
    {
        return ['reward_type' => RewardType::class];
    }

    public function requirements()
    {
        return $this->hasMany(AchievementRequirement::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_achievements')->withPivot('obtained_at');
    }
}
