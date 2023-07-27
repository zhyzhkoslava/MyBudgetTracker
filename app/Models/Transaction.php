<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transanctions';

    protected $fillable = [
        'type',
        'date',
        'amount',
        'description',
        'account_id'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
