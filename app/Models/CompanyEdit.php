<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyEdit extends Model
{
    protected $fillable = ['company_id', 'user_id', 'field', 'content', 'flag_count'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function flags()
    {
        return $this->hasMany(Flag::class);
    }

    public function getScoreAttribute(): int
    {
        return $this->votes->sum('value');
    }
}
