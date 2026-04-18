<?php

namespace App\Models;

use App\Enums\InstanceState as InstanceStateEnum;
use App\Enums\Priority;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyInstance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'board_id', 'company_id', 'owner_id',
        'current_state', 'rating', 'priority', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'current_state' => InstanceStateEnum::class,
            'priority' => Priority::class,
        ];
    }

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function states()
    {
        return $this->hasMany(InstanceState::class, 'instance_id');
    }

    public function reminders()
    {
        return $this->hasMany(InstanceReminder::class, 'instance_id');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'instance_id');
    }
}
