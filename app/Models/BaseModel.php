<?php

namespace App\Models;

use Carbon\Carbon;
use GlobalXtreme\Parser\Trait\HasParser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class BaseModel extends Model
{
    use GetOrPaginate;
    use SoftDeletes;
    use HasParser;
    use HasFactory;

    // Custom date times column
    const CREATED_AT = 'createdAt';

    const UPDATED_AT = 'updatedAt';

    const DELETED_AT = 'deletedAt';

    // Var for generate number
    public $numberPrefix = 'GX';

    /** --- SCOPES --- */
    public function scopeOfDate($query, $key = 'date', $fromDate = null, $toDate = null)
    {
        $fromDate = $fromDate ?: now()->subMonth()->format('d/m/Y');
        $toDate = $toDate ?: now()->format('d/m/Y');

        $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate)->startOfDay();
        $toDate = Carbon::createFromFormat('d/m/Y', $toDate)->endOfDay();

        return $query->whereBetween($key, [$fromDate, $toDate]);
    }

    /** --- FUNCTIONS --- */
    public function hasSearch($request)
    {
        return $request->has('search') && strlen($request->search) >= 3;
    }
}
