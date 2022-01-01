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
        $testUser = $userRepository->findOneByEmail('bar@gmail.com');

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $crawler = $client->request('GET', '/users');
        $this->assertResponseIsSuccessful();
        // $this->assertSelectorTextContains('p', 'On doit définir le budget prévisionnel de l\'année prochaine pour l\'équipe de comm.');
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
        $client->request('GET', '/users/create');
        $crawler = $client->submitForm('Ajouter', [
            'user[username]' => 'Fabien',
            'user[password][first]' => '123456',
            'user[password][second]' => '123456',
            'user[email]' => 'foo1@gmail.com',
        ]);
        $this->assertResponseRedirects();
        $crawler = $client->followRedirect();
        $this->assertResponseIsSuccessful();
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

        // select the button
        $buttonCrawlerNode = $crawler->selectButton('Modifier');

        // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();

        // set values on a form object
        $form['user[username]'] = 'newFabien';
        $form['user[password][first]'] = 'new123456';
        $form['user[password][second]'] = 'new123456';
        $form['user[email]'] = 'newfoo1@gmail.com';

        // submit the Form object
        $client->submit($form);

        $this->assertResponseRedirects();
        $crawler = $client->followRedirect();
        $this->assertResponseIsSuccessful();
    }
}
