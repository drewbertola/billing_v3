<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';

    protected $fillable = [
        'customerId',
        'invoiceId',
        'amount',
        'date',
        'method',
        'number',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerId');
    }
}
