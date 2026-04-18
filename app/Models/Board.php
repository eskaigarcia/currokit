<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Board extends Model
{
    use SoftDeletes;

    protected $fillable = ['owner_id', 'name', 'color', 'visibility'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function companyInstances()
    {
        return $this->hasMany(CompanyInstance::class);
    }

    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'board_collaborators')->withPivot('status', 'invited_at', 'accepted_at');
    }
}
