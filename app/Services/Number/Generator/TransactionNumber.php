<?php

namespace App\Services\Number\Generator;

use App\Models\Transaction\Transaction;
use App\Services\Number\BaseNumber;
use Illuminate\Database\Eloquent\Model;

class TransactionNumber extends BaseNumber
{
    protected static string $prefix = 'TSX';

    protected Model|string|null $model = Transaction::class;

    public static function generate(): string
    {
        $number = '';

        $date = now();
        $date = $date->format('dmy');

        $increment = static::getIncrementNumber();
        $number .= str_pad($increment, 5, '0', STR_PAD_LEFT);

        $letters = static::getLetters();

        //generate numbr after model created
        return strtoupper(static::$prefix.$number.$letters.$date);

        return '';
    }

    /** --- PRIVATE FUNCTION --- **/
    private static function getLetters($length = 10): string
    {
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle($letters), 0, $length);

        return '';
    }
}
