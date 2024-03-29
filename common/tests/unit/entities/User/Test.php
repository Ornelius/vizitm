<?php

namespace common\tests\unit\entities\User;

use Codeception\Test\Unit;
use common\entities\Users;

class Test extends Unit
{
    public function testSuccess()
    {
        $user = Users::signup(
            $username   =   'username',
            $email      =   'email@site.com',
            $password   =   'password'
        );

        $this->assertEquals($username, $user->username);
        $this->assertEquals($email, $user->email);
        $this->assertNotEmpty($user->password_hash);
        $this->assertNotEquals($password, $user->password_hash);
        $this->assertNotEmpty($user->created_at);
        $this->assertNotEmpty($user->auth_key);
        $this->assertTrue($user->isActive());

    }

}
