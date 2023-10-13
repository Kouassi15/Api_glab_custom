<?php

namespace App\Controller;

use App\Entity\Module;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Builder\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends AbstractController
{
    #[Route('/module', name: 'app_module')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ModuleController.php',
        ]);
    }

    #[Route('/api/modules', name: 'tous_module',methods:['GET'])]
    public function moduleAll(ManagerRegistry $doctrine): JsonResponse
    {
        $modules = $doctrine->getRepository(Module::class)->findAll();;
        $data = [];
        foreach ($modules as $module) {
           $data[] = [
               'id' => $module->getId(),
               'code' =>$module->getCode(),
               'libelle' => $module->getLibelle(),
               'description' => $module->getDescription(),
           ];
    }
    return $this->json($data);
}

#[Route('/api/ajouter/module', name: 'ajouter_module',methods:['POST'])]
public function ajoutModule(ManagerRegistry $doctrine,EntityManagerInterface $entityManager,Request $request): JsonResponse
{

     $request_data = json_decode($request->getContent(), true);
    //  dd($request_data['code']);
    $module = new Module();
    $module->setCode($request_data['code']);
    $module->setLibelle($request_data['libelle']);
    $module->setDescription($request_data['description']);

    $entityManager->persist($module);
    $entityManager->flush();

    $data =  [
        'id' => $module->getId(),
        'code' => $module->getCode(),
        'libelle' => $module->getLibelle(),
        'description' => $module->getDescription(),
    ];
       
    return $this->json($data);
}
//  reccuperer un module par son indentifiant 
#[Route('/api/module/{id}', name: 'show_module', methods: ['GET'])]
public function showModule(EntityManagerInterface $entityManager, int $id): JsonResponse
{
    $module = $entityManager->getRepository(Module::class)->find($id);

    if (!$module) {
        return $this->json("Aucun module trouvé de l'identifiant $id", 404);
    }

    $data = [
        'id' => $module->getId(),
        'code' => $module->getCode(),
        'libelle' => $module->getLibelle(),
        'description' => $module->getDescription(),
    ];

    return $this->json($data);
}

#[Route('/api/module/modifier/{id}', name: 'update_module', methods: ['PUT'])]
public function update(EntityManagerInterface $entityManager,Request $request, int $id): JsonResponse
{

    $request_data = json_decode($request->getContent(), true);
    
    $module = $entityManager->getRepository(Module::class)->find($id);

    if (!$module) {
        return $this->json(
            [
                'code' => 404,
                'message' => 'Aucun module trouvé pour l"identifiant'  . $id, 
            ],
            404
        );
    }
    $module->setCode($request_data['code']);
    $module->setLibelle($request_data['libelle']);
    $module->setDescription($request_data['description']);
    $entityManager->flush();
   
    $data = [
        'id' => $module->getId(),
        'code' => $module->getCode(),
        'libelle' => $module->getLibelle(),
        'description' => $module->getDescription(),
    ];

    return $this->json($data);
}

#[Route('api/module/supprimer/{id}', name: 'module_delete', methods:['delete'] )]
    public function delete(Request $request,EntityManagerInterface $entityManager, int $id): JsonResponse
    {
         $module = $entityManager->getRepository(Module::class)->find($id);
        if (!$module) {
            return $this->json('Aucun module trouvé pour l"identifiant'  . $id, 404);
        }
   
        $entityManager->remove($module);
        $entityManager->flush();
   
        return $this->json('Suppression réussie avec succès l"identifiant ' . $id);

    }
}