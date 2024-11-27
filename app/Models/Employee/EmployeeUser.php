<?php

namespace App\Models\Employee;

use App\Models\Employee\Traits\HasActivityEmployeeUserProperty;
use App\Models\GetOrPaginate;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class EmployeeUser extends Authenticatable implements JWTSubject
{
    use GetOrPaginate, HasActivityEmployeeUserProperty;

    protected $table = 'employee_users';

    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
    ];

    const CREATED_AT = 'createdAt';

    const UPDATED_AT = 'updatedAt';


    /** --- RELATIONSHIP --- **/

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }


    /** --- JWT --- */

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
