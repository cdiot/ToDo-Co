<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testIsTrue()
    {
        $user = new User();
        $user->setUsername('foo123')
            ->setEmail('foo@gmail.com')
            ->setRoles(['ROLE_USER'])
            ->setPassword('123456');

        $this->assertTrue($user->getUsername() === 'foo123');
        $this->assertTrue($user->getEmail() === 'foo@gmail.com');
        $this->assertTrue($user->getRoles() === ['ROLE_USER']);
        $this->assertTrue($user->getPassword() === '123456');
    }

    public function testIsFalse()
    {
        $user = new User();
        $user->setUsername('bar123')
            ->setEmail('bar@gmail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('azerty');

        $this->assertFalse($user->getUsername() === 'foo123');
        $this->assertFalse($user->getEmail() === 'foo@gmail.com');
        $this->assertFalse($user->getRoles() === ['ROLE_USER']);
        $this->assertFalse($user->getPassword() === '123456');
    }

    public function testIsEmpty()
    {
        $user = new User();
        $user->setUsername('')
            ->setEmail('')
            ->setPassword('');

        $this->assertEmpty($user->getUsername());
        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getPassword());
    }
}
