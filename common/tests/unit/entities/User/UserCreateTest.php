<?php


namespace common\tests\unit\entities\User;
use Codeception\Test\Unit;
use vizitm\entities\User;

class UserCreateTest extends Unit
{
    public function testSuccess()
    {
        $user = User::signup(
            $username = 'test',
            $email = 'test@test.com',
            $password = 'password',
            $role = User::STATUS_ACTIVE
        );

        $this->assertEquals($username, $user->username);
        $this->assertEquals($email, $user->email);
        $this->assertNotEmpty($user->password_hash);
        $this->assertNotEquals($password, $user->password_hash);
        $this->assertNotEmpty($user->created_at);
        $this->assertNotEmpty($user->auth_key);
        $this->assertTrue($user->isActive());
        $this->assertNotEmpty($role, $user->role);

    }

}