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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /** Relationship **/
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
