<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchievementRequirement extends Model
{
    protected $fillable = ['achievement_id', 'condition_key', 'operator', 'threshold'];

    public function achievement()
    {
        return $this->belongsTo(Achievement::class);
    }

    public function isSatisfiedBy(int $value): bool
    {
        return match ($this->operator) {
            '>=' => $value >= $this->threshold,
            '>' => $value > $this->threshold,
            '==' => $value === $this->threshold,
            '<=' => $value <= $this->threshold,
            '<' => $value < $this->threshold,
            default => false,
        };
    }
}
