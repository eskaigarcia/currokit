<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'creator_id', 'name', 'profile_icon', 'industry', 'fields',
        'tools_skills', 'desired_profile', 'linkedin_link', 'description',
        'verified', 'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'verified' => 'boolean',
            'verified_at' => 'datetime',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function instances()
    {
        return $this->hasMany(CompanyInstance::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function reviews()
    {
        return $this->hasMany(CompanyReview::class);
    }

    public function edits()
    {
        return $this->hasMany(CompanyEdit::class);
    }

    public function sponsoredContent()
    {
        return $this->hasMany(PlatformContent::class, 'sponsor_id');
    }
}
