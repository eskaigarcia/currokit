<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardCollaborator extends Model
{
    public $timestamps = false;

    protected $fillable = ['board_id', 'user_id', 'status', 'invited_at', 'accepted_at'];

    protected function casts(): array
    {
        return [
            'invited_at' => 'datetime',
            'accepted_at' => 'datetime',
        ];
    }

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
