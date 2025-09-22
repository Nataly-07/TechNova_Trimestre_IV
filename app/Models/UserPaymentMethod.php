<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPaymentMethod extends Model
{
    protected $fillable = [
        'user_id', 'brand', 'last4', 'holder_name', 'token',
        'exp_month', 'exp_year', 'email', 'phone', 'installments'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


