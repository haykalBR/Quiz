<?php

namespace App\Core\DataFixtures;

use App\Domain\Categories\Entity\Categories;
use App\Domain\Categories\Entity\Technology;
use App\Domain\Categories\Repository\CategoriesRepository;
use App\Domain\User\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InitFixtures extends Fixture
{

    private UserPasswordHasherInterface $userPasswordHasher;
    private CategoriesRepository $categoriesRepository;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher,CategoriesRepository $categoriesRepository)
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->categoriesRepository = $categoriesRepository;
    }
    public function load(ObjectManager $manager)
    {
        $this->addUsers($manager);
        $this->addCategory($manager);


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
        $manager->flush();
    }
    private function addCategory(ObjectManager  $manager){
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
        $manager->flush();
    }

}