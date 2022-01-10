<?php

namespace App\Tests;

use App\DataFixtures\AppFixtures;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    protected AbstractDatabaseTool $databaseTool;
    protected EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
    }

    public function testShouldDisplayList()
    {
        //$client = static::createClient();

        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('bar@gmail.com');

        $this->client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $this->client->request('GET', '/tasks');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('p', 'On doit définir');
    }

    public function testShouldDisplayCreate()
    {
        //$client = static::createClient();

        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('bar@gmail.com');

        $this->client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $crawler = $this->client->request('GET', '/tasks/create');
        $crawler = $this->client->submitForm('Ajouter', [
            'task[title]' => 'Ma super tache!',
            'task[content]' => 'Une tache unique en sont genre!'
        ]);
        $this->assertResponseRedirects();
        $crawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testShouldDisplayEdit()
    {
        // $client = static::createClient();

        $this->databaseTool->loadFixtures([
            AppFixtures::class
        ]);

        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('bar@gmail.com');

        $this->client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $crawler = $this->client->request('GET', '/tasks/3/edit');

        // select the button
        $buttonCrawlerNode = $crawler->selectButton('Modifier');

        // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();

        // set values on a form object
        $form['task[title]'] = 'Ma nouvelle super tache!';
        $form['task[content]'] = 'Une nouvelle tache unique en sont genre!';

        // submit the Form object
        $this->client->submit($form);

        $this->assertResponseRedirects();
        $crawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testShouldDisplayToggle()
    {
        // $client = static::createClient();

        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('bar@gmail.com');

        $this->client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $this->client->request('GET', '/tasks/1/toggle');
        $this->assertResponseRedirects();
        $crawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testShouldDisplayDelete()
    {
        /*
        $this->databaseTool->loadFixtures([
            AppFixtures::class
        ]);
        */

        //  $client = static::createClient();

        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('bar@gmail.com');

        $this->client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $this->client->request('GET', '/tasks/3/delete');
        $this->assertResponseRedirects();
        $crawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }
}
