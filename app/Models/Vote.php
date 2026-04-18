<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['user_id', 'company_edit_id', 'value', 'weight'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function edit()
    {
        return $this->belongsTo(CompanyEdit::class, 'company_edit_id');
    }
}
