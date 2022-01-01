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
        $testUser = $userRepository->findOneByEmail('bar@gmail.com');

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/tasks');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('p', 'On doit définir');
    }

    public function testShouldDisplayCreate()
    {
        $client = static::createClient();

        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('bar@gmail.com');

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $crawler = $client->request('GET', '/tasks/create');
        $crawler = $client->submitForm('Ajouter', [
            'task[title]' => 'Ma super tache!',
            'task[content]' => 'Une tache unique en sont genre!'
        ]);
        $this->assertResponseRedirects();
        $crawler = $client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testShouldDisplayEdit()
    {
        $client = static::createClient();

        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('bar@gmail.com');

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $crawler = $client->request('GET', '/tasks/3/edit');

        // select the button
        $buttonCrawlerNode = $crawler->selectButton('Modifier');

        // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();

        // set values on a form object
        $form['task[title]'] = 'Ma nouvelle super tache!';
        $form['task[content]'] = 'Une nouvelle tache unique en sont genre!';

        // submit the Form object
        $client->submit($form);

        $this->assertResponseRedirects();
        $crawler = $client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testShouldDisplayToggle()
    {
        $client = static::createClient();

        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('bar@gmail.com');

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/tasks/1/toggle');
        $this->assertResponseRedirects();
        $crawler = $client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testShouldDisplayDelete()
    {
        $client = static::createClient();

        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('bar@gmail.com');

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/tasks/3/delete');
        $this->assertResponseRedirects();
        $crawler = $client->followRedirect();
        $this->assertResponseIsSuccessful();
    }
}
