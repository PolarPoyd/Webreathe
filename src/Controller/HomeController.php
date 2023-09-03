<?php

namespace App\Controller;

use App\Command\RandomDataCommand;
use App\Repository\ModuleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ModuleRepository $moduleRepository): Response
    {
        $modules = $moduleRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'modules' => $modules,
        ]);
    }

    #[Route('/enable-data-injection', name: 'enable_data_injection')]
    public function enableDataInjection(RandomDataCommand $randomDataCommand): Response
    {
        $randomDataCommand->enableDataInjection();

        return $this->redirectToRoute('app_home');
    }

    #[Route('/disable-data-injection', name: 'disable_data_injection')]
    public function disableDataInjection(RandomDataCommand $randomDataCommand): Response
    {
        $randomDataCommand->disableDataInjection();

        return $this->redirectToRoute('app_home');
    }

    #[Route('/latest-data-api', name: 'app_latest_data_api', methods: ['GET'])]
    public function getLatestDataApi(ModuleRepository $moduleRepository): JsonResponse
    {
        $latestData = [];
    
        foreach ($moduleRepository->findAll() as $module) {
            $latestModuleData = $module->getModuleData()->last();
            if ($latestModuleData) {
                // Convertir la date et l'heure au format français
                $createdAt = $latestModuleData->getCreatedAt()->setTimezone(new \DateTimeZone('Europe/Paris'));
                $formattedCreatedAt = $createdAt->format('le d/m/Y à H:i');
    
                $latestData[] = [
                    'moduleId' => $module->getId(),
                    'temperature' => $latestModuleData->getTemperature(),
                    'energy' => $latestModuleData->getEnergy(),
                    'broken' => $latestModuleData->getBroken(),
                    'createdAt' => $formattedCreatedAt,
                ];
            }
        }
    
        return new JsonResponse($latestData);
    }
}
