<?php

namespace App\Tests;

use App\Entity\Task;
use App\Entity\User;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testIsTrue()
    {
        $task = new Task();
        $user = new User();
        $date = new DateTimeImmutable();
        $task->setCreatedAt($date);
        $task->setTitle('Recrutement');
        $task->setContent('On doit définir le budget prévisionnel.');
        $task->toggle(0);
        $task->setUser($user);

        $this->assertTrue($task->getCreatedAt() === $date);
        $this->assertTrue($task->getTitle() === 'Recrutement');
        $this->assertTrue($task->getContent() === 'On doit définir le budget prévisionnel.');
        $this->assertTrue($task->isDone() === 0);
        $this->assertTrue($task->getUser() === $user);
    }

    public function testIsFalse()
    {
        $task = new Task();
        $user = new User();
        $date = new DateTimeImmutable();
        $yesterday = $date->modify('-1 day');
        $task->setCreatedAt($yesterday);
        $task->setTitle('Passage en prod');
        $task->setContent('On doit passer en production.');
        $task->toggle(1);
        $task->setUser($user);

        $this->assertFalse($task->getCreatedAt() === $date);
        $this->assertFalse($task->getTitle() === 'Recrutement');
        $this->assertFalse($task->getContent() === 'On doit définir le budget prévisionnel.');
        $this->assertFalse($task->isDone() === 0);
        $this->assertFalse($task->getUser() === new User());
    }

    public function testIsEmpty()
    {
        $task = new Task();

        $this->assertEmpty($task->getTitle());
        $this->assertEmpty($task->getContent());
        $this->assertEmpty($task->isDone());
        $this->assertEmpty($task->getUser());
        $this->assertEmpty($task->getId());
    }
}
