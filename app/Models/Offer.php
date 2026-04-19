<?php

namespace App\Models;

use App\Enums\OfferState as OfferStateEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id', 'instance_id', 'user_id',
        'position', 'linkedin_link', 'current_state', 'notes',
    ];

    protected function casts(): array
    {
        return ['current_state' => OfferStateEnum::class];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function instance()
    {
        return $this->belongsTo(CompanyInstance::class, 'instance_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function states()
    {
        return $this->hasMany(OfferState::class);
    }
}
