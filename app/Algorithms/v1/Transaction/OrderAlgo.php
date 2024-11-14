<?php
namespace App\Algorithms\v1\Transaction;

use App\Http\Controllers\Web\v1\Transaction\Order;

class OrderAlgo
{
    public function __construct(public ?Order $order = null)
    {
        
    }
}