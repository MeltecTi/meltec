<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_user_can_set_name(): void
    {
        $user = new User();

        $user ->setKeyName('Jhon Doe');
        
        $this->assertEquals('Jhon Doe', $user->getKeyName());
    }
}
