<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';

    protected $fillable = [
        'customerId',
        'amount',
        'date',
        'emailed',
        'note',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerId');
    }
}
