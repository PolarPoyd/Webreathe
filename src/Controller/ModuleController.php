<?php

namespace App\Controller;

use Faker\Factory;
use App\Entity\Module;
use App\Form\ModuleType;
use App\Entity\ModuleData;
use App\Repository\ModuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/module')]
class ModuleController extends AbstractController
{
    #[Route('/', name: 'app_module_index', methods: ['GET'])]
    public function index(ModuleRepository $moduleRepository): Response
    {
        return $this->render('module/index.html.twig', [
            'modules' => $moduleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_module_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $module = new Module();
    
        // Utilisation de Faker pour générer des données aléatoires
        $faker = Factory::create();
        
        $moduleData = new ModuleData();
        $moduleData->setCreatedAt(new \DateTimeImmutable());
        $moduleData->setTemperature($faker->randomFloat(2, 18, 30)); // Température aléatoire entre 18°C et 30°C
        $moduleData->setEnergy($faker->randomNumber(3)); // Énergie aléatoire sur trois chiffres
        $moduleData->setBroken($faker->randomElement([0, 1])); // État aléatoire (cassé ou non)
        
        $module->addModuleData($moduleData);

        // Ajouter des données aléatoires supplémentaires au module
        for ($i = 0; $i < 5; $i++) {
        $additionalModuleData = new ModuleData();
        $additionalModuleData->setCreatedAt(new \DateTimeImmutable());
        $additionalModuleData->setTemperature($faker->randomFloat(2, 18, 30));
        $additionalModuleData->setEnergy($faker->randomNumber(3));
        $additionalModuleData->setBroken($faker->randomElement([0, 1]));
        
        $module->addModuleData($additionalModuleData);
    }
        
        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash(
                'danger',
                'Oups, veuillez réessayer !'
            );
        }
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($module);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Module ajouté avec succès !'
            );
    
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('module/new.html.twig', [
            'module' => $module,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_module_show', methods: ['GET'])]
    public function show(Module $module): Response
    {
        return $this->render('module/show.html.twig', [
            'module' => $module,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_module_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Module $module, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash(
                'danger',
                'Oups, veuillez réessayer !'
            );
        }
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            $this->addFlash(
                'success',
                'Module modifié avec succès !'
            );
    
            return $this->redirectToRoute('app_module_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('module/edit.html.twig', [
            'module' => $module,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_module_delete', methods: ['POST'])]
    public function delete(Request $request, Module $module, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$module->getId(), $request->request->get('_token'))) {
            // Supprimer les enregistrements ModuleData associés
            foreach ($module->getModuleData() as $moduleData) {
                $entityManager->remove($moduleData);
            }
            
            // Supprimer l'entité Module
            $entityManager->remove($module);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('app_module_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/show-module-data', name: 'app_module_show_module_data', methods: ['GET'])]
    public function showModuleData(Module $module): Response
    {
        return $this->render('module/show_module_data.html.twig', [
        'module' => $module,
    ]);
    }
    
}


