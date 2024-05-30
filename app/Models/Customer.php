<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';

    protected $fillable = [
        'name',
        'bAddress1',
        'bAddress2',
        'bCity',
        'bState',
        'bZip',
        'sAddress1',
        'sAddress2',
        'sCity',
        'sState',
        'sZip',
        'phoneMain',
        'fax',
        'billingContact',
        'billingEmail',
        'billingPhone',
        'primaryContact',
        'primaryEmail',
        'primaryPhone',
        'taxable',
        'archive',
    ];

    public static function getTableData()
    {
        $invoice = DB::table('invoice')
            ->select('customerId',
                DB::raw('max(id) as id'),
                DB::raw('sum(amount) as amount'),
                DB::raw('max(date) as date'))
            ->groupBy('customerId');

        $payment = DB::table('payment')
            ->select('customerId',
                DB::raw('max(id) as id'),
                DB::raw('sum(amount) as amount'),
                DB::raw('max(date) as date'))
            ->groupBy('customerId');


        $collection = DB::table('customer')
            ->select(
                'customer.id as id',
                'customer.archive as archive',
                'customer.name as name',
                'customer.primaryContact as primaryContact',
                DB::raw('ifnull(i.id, 0) as lastInvId'),
                DB::raw('ifnull(i.date, "") as lastInvDate'),
                DB::raw('ifnull(p.amount, 0) - ifnull(i.amount, 0) as balance'),
                DB::raw('"" as inv'),
                DB::raw('"" as pmt')
            )
            ->leftJoinSub($invoice, 'i', function (JoinClause $join) {
                $join->on('customer.id', '=', 'i.customerId');
            })
            ->leftJoinSub($payment, 'p', function (JoinClause $join) {
                $join->on('customer.id', '=', 'p.customerId');
            })->get();

        return $collection;
    }
}
