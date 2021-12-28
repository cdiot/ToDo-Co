<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testShouldDisplayList()
    {
        $client = static::createClient();

        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('foo@gmail.com');

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $crawler = $client->request('GET', '/tasks');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('p', 'On doit définir le budget prévisionnel de l\'année prochaine pour l\'équipe de comm.');
    }

    public function testShouldDisplayCreate()
    {
        $client = static::createClient();

        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('foo@gmail.com');

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $crawler = $client->request('GET', '/tasks/create');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('button', 'Ajouter');
    }

    public function testShouldDisplayEdit()
    {
        $client = static::createClient();

        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('foo@gmail.com');

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $crawler = $client->request('GET', '/tasks/1/edit');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('button', 'Modifier');
    }

    public function testShouldDisplayToggle()
    {
        $client = static::createClient();

        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('foo@gmail.com');

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $crawler = $client->request('GET', '/tasks/1/toggle');
        $this->assertResponseRedirects();
    }

    public function testShouldDisplayDelete()
    {
        $client = static::createClient();

        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('foo@gmail.com');

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $crawler = $client->request('GET', '/tasks/1/delete');
        $this->assertResponseRedirects();
    }
}
