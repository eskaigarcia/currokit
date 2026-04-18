<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstanceState extends Model
{
    public $timestamps = false;

    protected $fillable = ['instance_id', 'state', 'set_at', 'unset_at'];

    protected function casts(): array
    {
        return [
            'set_at' => 'datetime',
            'unset_at' => 'datetime',
        ];
    }

    public function instance()
    {
        return $this->belongsTo(CompanyInstance::class, 'instance_id');
    }
}
