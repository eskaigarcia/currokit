<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flag extends Model
{
    protected $fillable = ['user_id', 'company_edit_id', 'reason'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function edit()
    {
        return $this->belongsTo(CompanyEdit::class, 'company_edit_id');
    }
}
