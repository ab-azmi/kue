<?php

namespace App\Models\v1\Salary;

use App\Models\BaseModel;
use App\Models\v1\Salary\Traits\HasActivitySalaryProperty;
use App\Models\v1\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Salary extends BaseModel
{
    use HasActivitySalaryProperty;
    
    protected $table = 'salaries';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime'
    ];

    // ------------------------------ RELATIONSHIP ------------------------------

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId');
    }

}
