<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'user_name', 'display_name', 'password',
        'role', 'level', 'vote_weight', 'points', 'premium_status',
        'premium_until', 'trial_ends_at', 'profile_picture', 'preferences',
        'banned', 'banned_at', 'ban_reason',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'premium_status' => 'boolean',
            'premium_until' => 'datetime',
            'trial_ends_at' => 'datetime',
            'preferences' => 'array',
            'banned' => 'boolean',
            'banned_at' => 'datetime',
        ];
    }

    // --- Preference helpers stored on the user JSON column ---

    public function getPreference(string $key, mixed $default = null): mixed
    {
        return data_get($this->preferences, $key, $default);
    }

    public function setPreference(string $key, mixed $value): void
    {
        $prefs = $this->preferences ?? [];
        data_set($prefs, $key, $value);
        $this->preferences = $prefs;
        $this->save();
    }

    // --- Relationships ---

    public function boards()
    {
        return $this->hasMany(Board::class, 'owner_id');
    }

    public function companyInstances()
    {
        return $this->hasMany(CompanyInstance::class, 'owner_id');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function companies()
    {
        return $this->hasMany(Company::class, 'creator_id');
    }

    public function reviews()
    {
        return $this->hasMany(CompanyReview::class);
    }

    public function edits()
    {
        return $this->hasMany(CompanyEdit::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function flags()
    {
        return $this->hasMany(Flag::class);
    }

    public function contentInteractions()
    {
        return $this->hasMany(UserContentInteraction::class);
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'users_achievements')->withPivot('obtained_at');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function collaboratingBoards()
    {
        return $this->belongsToMany(Board::class, 'board_collaborators')->withPivot('status', 'invited_at', 'accepted_at');
    }

    // --- Stats ---

    public function getStat(string $conditionKey): int
    {
        return match ($conditionKey) {
            'companies_created' => $this->companies()->count(),
            'contributions_made' => $this->edits()->count(),
            'times_voted' => $this->votes()->count(),
            'instances_created' => $this->companyInstances()->count(),
            'offers_tracked' => $this->offers()->count(),
            'content_liked' => $this->contentInteractions()->where('type', 'liked')->count(),
            'content_shared' => 0,
            'likes_to_contributions' => $this->edits()->withCount('votes')->get()->sum('votes_count'),
            default => 0,
        };
    }

    public function isBanned(): bool
    {
        return $this->banned === true;
    }
}
