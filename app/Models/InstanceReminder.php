<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstanceReminder extends Model
{
    protected $fillable = ['instance_id', 'content', 'type', 'reminding_at'];

    protected function casts(): array
    {
        return ['reminding_at' => 'datetime'];
    }

    public function instance()
    {
        return $this->belongsTo(CompanyInstance::class, 'instance_id');
    }
}
