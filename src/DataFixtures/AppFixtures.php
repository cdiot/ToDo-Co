<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @codeCoverageIgnore
 */
class AppFixtures extends Fixture
{
    private $passwordHasher;

    private $tasksData = [
        1 => [
            'title' => 'Budget prévisionnel',
            'content' => 'On doit définir le budget prévisionnel de l\'année prochaine pour l\'équipe de comm.',
            'isDone' => 0,
            'user' => 0
        ],
        2 => [
            'title' => 'Recrutement',
            'content' => 'On doit définir les compétences clés que doivent avoir nos candidats pour l\'avenir de notre entreprise.',
            'isDone' => 0,
            'user' => 1
        ],
        3 => [
            'title' => 'Passage en prod',
            'content' => 'On doit passer en production le travail effectué par l\'équipe de développement pour vendredi.',
            'isDone' => 0,
            'user' => 1
        ]
    ];

    private $usersData = [
        1 => [
            'username' => 'foo123',
            'email' => 'foo@gmail.com',
            'roles' => 'ROLE_USER',
            'password' => '123456'
        ],
        2 => [
            'username' => 'bar123',
            'email' => 'bar@gmail.com',
            'roles' => 'ROLE_ADMIN',
            'password' => '123456'
        ],
    ];

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Add 2 User
        $users = [];
        foreach ($this->usersData as $key => $value) {
            $user = new User();
            $user->setUsername($value['username']);
            $user->setEmail($value['email']);
            $user->setRoles([$value['roles']]);
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                $value['password']
            ));
            $users[] = $user;
        }

        $manager->persist($user);

        // Create 3 Tasks
        foreach ($this->tasksData as $key => $value) {
            $today = new DateTime();
            $task = new Task();
            $task->setCreatedAt($today);
            $task->setTitle($value['title']);
            $task->setContent($value['content']);
            $task->toggle($value['isDone']);
            $task->setUser($users[$value['user']]);

            $manager->persist($task);
        }

        $manager->flush();
    }
}
