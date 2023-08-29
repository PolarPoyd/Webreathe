<?php

namespace App\Service;

use Faker\Factory;
use App\Entity\ModuleData;
use Doctrine\ORM\EntityManagerInterface;

class ModuleDataUpdater
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function updateModuleData()
    {
        $moduleRepository = $this->entityManager->getRepository(Module::class);
        $modules = $moduleRepository->findAll();

        $faker = Factory::create();

        foreach ($modules as $module) {
            $moduleData = new ModuleData();
            $moduleData->setCreatedAt(new \DateTimeImmutable());
            $moduleData->setTemperature($faker->randomFloat(2, 18, 30));
            $moduleData->setEnergy($faker->randomNumber(3));
            $moduleData->setBroken($faker->randomElement([0, 1]));

            $module->addModuleData($moduleData);

            $this->entityManager->persist($moduleData);
            $this->entityManager->flush();
        }
    }
}
