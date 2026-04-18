<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferState extends Model
{
    public $timestamps = false;

    protected $fillable = ['offer_id', 'state', 'set_at', 'unset_at'];

    protected function casts(): array
    {
        return [
            'set_at' => 'datetime',
            'unset_at' => 'datetime',
        ];
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
