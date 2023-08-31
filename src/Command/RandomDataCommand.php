<?php

namespace App\Command;

use App\Entity\Module;
use App\Entity\ModuleData;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class RandomDataCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private bool $dataInjectionEnabled = true;
    private string $lockFilePath = __DIR__ . '/random_data_lock';

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->loadLockStatus();
    }

    protected function configure()
    {
        $this
            ->setName('app:add-random-data')
            ->setDescription('Ajoute des données aléatoire moduleData pour chaque module existant')
            ->addOption('enable', null, InputOption::VALUE_NONE, 'Activer l\'injection de données')
            ->addOption('disable', null, InputOption::VALUE_NONE, 'Désactiver l\'injection de données');
    }

    public function enableDataInjection(): void
    {
        $this->dataInjectionEnabled = true;
        $this->saveLockStatus();
    }

    public function disableDataInjection(): void
    {
        $this->dataInjectionEnabled = false;
        $this->saveLockStatus();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('enable')) {
            $this->enableDataInjection();
            $output->writeln('L\'injection de données a été activée.');
            return Command::SUCCESS;
        }

        if ($input->getOption('disable')) {
            $this->disableDataInjection();
            $output->writeln('L\'injection de données a été désactivée.');
            return Command::SUCCESS;
        }

        if (!$this->dataInjectionEnabled) {
            $output->writeln('L\'injection de données est actuellement désactivée.');
            return Command::SUCCESS;
        }

        if ($this->isLocked()) {
            $output->writeln('L\'injection de données est actuellement désactivée.');
            return Command::SUCCESS;
        }

        // Injection des data aléatoire
        $faker = Factory::create();

        $modules = $this->entityManager->getRepository(Module::class)->findAll();

        foreach ($modules as $module) {
            $moduleData = new ModuleData();
            $moduleData->setCreatedAt(new \DateTimeImmutable());
            $moduleData->setTemperature($faker->randomFloat(2, 18, 30));
            $moduleData->setEnergy($faker->randomNumber(3));
            $moduleData->setBroken($faker->boolean);

            $module->addModuleData($moduleData);

            $this->entityManager->persist($moduleData);
        }

        $this->entityManager->flush();

        $output->writeln('Données aléatoires ajoutées.');
        
        return Command::SUCCESS;
    }

    private function isLocked(): bool
    {
        return file_exists($this->lockFilePath);
    }

    private function loadLockStatus(): void
    {
        $this->dataInjectionEnabled = !$this->isLocked();
    }

    private function saveLockStatus(): void
    {
        if ($this->dataInjectionEnabled) {
            if (file_exists($this->lockFilePath)) {
                unlink($this->lockFilePath);
            }
        } else {
            touch($this->lockFilePath);
        }
    }
}