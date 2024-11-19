<?php

namespace App\Models\User;

use App\Models\Employee\Employee;
use App\Models\Salary\Salary;
use App\Models\Transaction\Transaction;
use App\Models\User\Traits\HasActivityUserProperty;
use App\Observers\User\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements JWTSubject
{
    use HasActivityUserProperty;
    
    protected $table = 'users';
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

    public function salary(): HasOne
    {
        return $this->hasOne(Salary::class, 'userId');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'cashierId');
    }

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class, 'userId');
    }
}
