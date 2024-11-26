<?php

namespace Tests\Feature\Employee;

use App\Models\Employee\EmployeeUser;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    //set authentication
    public function setUp(): void
    {
        parent::setUp();

        $user = EmployeeUser::first();

        $token = JWTAuth::fromUser($user);

        $this->withHeader('Authorization', 'Bearer ' . $token);
    }
    

    public function test_get_employee_successfully(): void
    {
        $response = $this->get('/api/web/v1/kue/employees');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status' => [
                'code',
                'message',
                'internalMsg',
                'attributes'
            ],
            'result' => [
                '*' => [
                    'id',
                    'userId',
                    'address',
                    'phone',
                    'bankNumber',
                    'user',
                ],
            ],
        ]);        
    }
}