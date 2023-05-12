<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'easypaisa_account_number',
        'bank_account_number',
        'bank_name',
        'amount',
        'recipient',
        'user_id'


    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
