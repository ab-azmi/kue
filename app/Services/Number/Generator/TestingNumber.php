<?php

namespace App\Services\Number\Generator;

use App\Services\Number\BaseNumber;
use Illuminate\Database\Eloquent\Model;

class TestingNumber extends BaseNumber
{
    protected static string $prefix = 'TXT';

    protected Model|string|null $model = null;
}
