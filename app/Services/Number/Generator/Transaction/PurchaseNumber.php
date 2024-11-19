<?php

namespace App\Services\Number\Generator\Transaction;

use App\Models\Transaction\Transaction;
use App\Services\Number\BaseNumber;
use Illuminate\Database\Eloquent\Model;

class PurchaseNumber extends BaseNumber
{
    /**
     * @var string
     */
    protected static string $prefix = "TSX";

    /**
     * @var Model|string|null
     */
    protected Model|string|null $model = Transaction::class;

    public static function generate(): string
    {
        // TODO : Custom NUMBER pattern
        return '';
    }



}
