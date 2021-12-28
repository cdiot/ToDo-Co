<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
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
        // $this->assertSelectorTextContains('p', 'On doit définir le budget prévisionnel de l\'année prochaine pour l\'équipe de comm.');
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

    public function testShouldUserDisplayEdit()
    {
        $client = static::createClient();

        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('bar@gmail.com');

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $crawler = $client->request('GET', '/users/2/edit');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('button', 'Modifier');
    }
}
