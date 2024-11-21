<?php

namespace App\Services\Number\Generator;

use App\Models\Transaction\Transaction;
use App\Services\Number\BaseNumber;
use Illuminate\Database\Eloquent\Model;

class TransactionNumber extends BaseNumber
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
        // TSX000001FJDOENVDS210924
        $number = '';

        $date = now();
        $date = $date->format('dmy');

        $increment = static::getIncrement();
        $number .= str_pad($increment, 5, '0', STR_PAD_LEFT);
        
        $letters = static::getLetters();

        //generate numbr after model created
        return strtoupper(static::$prefix . $number . $letters . $date);
        return '';
    }

    /** --- PRIVATE FUNCTION --- **/

    private static function getIncrement(): string
    {
        try {
            return (new static())->model::withTrashed()
                ->where(function ($query) {
                    $date = now();
                    $query->whereMonth('createdAt', $date->month)
                        ->whereYear('createdAt', $date->year);
                })->count() + 1;
        } catch (\Exception $e) {
            exception($e);
        }
        return '';
    }

    private static function getLetters($length = 10): string
    {
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($letters), 0, $length);
        return '';
    }
}
