<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class InvoicesFilter extends ApiFilter
{
    protected $safeParms = [
        'customerId' => ['eq'],
        'amount' => ['eq', 'gt', 'gte', 'lt', 'lte'],
        'status' => ['eq', 'ne'], // ne - не равно
        'billedDate' => ['eq', 'gt', 'gte', 'lt', 'lte'],
        'paidDate' => ['eq', 'gt', 'gte', 'lt', 'lte'],
    ];

    protected $columnMap = [
        'customerId' => 'customer_id',
        'billedDate' => 'billed_date',
        'paidDate' => 'paid_date'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<', 
        'lte' => '<=', 
        'gt' => '>', 
        'gte' => '>=',
        'ne' => '!='
    ];
}
