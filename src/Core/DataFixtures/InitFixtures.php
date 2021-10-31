<?php

namespace App\Core\DataFixtures;

use App\Domain\Categories\Entity\Categories;
use App\Domain\User\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InitFixtures extends Fixture
{

    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }
    public function load(ObjectManager $manager)
    {
        $this->addUsers($manager);
        $this->addCategory($manager);
        $manager->flush();

    }
    private function addUsers(ObjectManager $manager){
        $user = new User();
        $user->setEmail("haikelbrinis@gmail.com");
        $user->setEnabled(true);
        $hashedPassword = $this->userPasswordHasher->hashPassword($user, "haikel");
        $user->setPassword($hashedPassword);
        $manager->persist($user);
        for ($i = 0; $i < 20; ++$i) {
            $user = new User();
            $user->setEmail("haikelbrinis{$i}@gmail.com");
            $user->setEnabled(true);
            $hashedPassword = $this->userPasswordHasher->hashPassword($user, "haikel{$i}");
            $user->setPassword($hashedPassword);
            $manager->persist($user);
        }
    }
    private function addCategory(ObjectManager  $manager){
        //ADD priciê technoligue to Category and delete sub category
        $categories=['développement mobile','développement web','administrateur systèmes',
                     'Administrateur/Administratrice de base de données','Testeur/Testeuse','Ingénieur/Ingénieure cloud computing',
                     'Ingénieur/Ingénieure télécoms et réseaux' , 'référencement','Webdesigner' ,'Marketing'
        ];
        foreach ($categories as $category){
            $categorie = new Categories();
            $categorie->setPublic(true);
            $categorie->setName($category);
            $manager->persist($categorie);
        }
    }
}