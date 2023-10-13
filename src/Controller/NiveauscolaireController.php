<?php

namespace App\Controller;

use App\Entity\NiveauScolaire;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NiveauscolaireController extends AbstractController
{
    #[Route('/niveauscolaire', name: 'app_niveauscolaire')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/NiveauscolaireController.php',
        ]);
    }

    #[Route('/api/niveauscolaires', name: 'tous_niveauscolaire',methods:['GET'])]
    public function niveauScolaireAll(ManagerRegistry $doctrine): JsonResponse
    {
        $niveauScolaires = $doctrine->getRepository(NiveauScolaire::class)->findAll();;
        $data = [];
        foreach ($niveauScolaires as $niveauScolaire) {
           $data[] = [
               'id' => $niveauScolaire->getId(),
               'code' =>$niveauScolaire->getCode(),
               'libelle' => $niveauScolaire->getLibelle(),
               'description' => $niveauScolaire->getDescription(),
           ];
    }
        return $this->json($data);
    }

    #[Route('/api/ajouter/niveauscolaire', name: 'ajouter_niveauscolaire',methods:['POST'])]
    public function createniveauScolaire( Request $request,EntityManagerInterface $entityManager): JsonResponse
    {
       $request_data = json_decode($request->getContent(),true);

       $niveauScolaire = new NiveauScolaire();
       $niveauScolaire ->setCode($request_data['code']);
       $niveauScolaire ->setLibelle($request_data['libelle']);
       $niveauScolaire ->setDescription($request_data['description']);

       $entityManager->persist($niveauScolaire);
       $entityManager->flush();
       
       $data = [
        'id' => $niveauScolaire->getId(),
        'code' =>$niveauScolaire->getCode(),
        'libelle' => $niveauScolaire->getLibelle(),
        'description' => $niveauScolaire->getDescription(),
    ];

    return $this->json($data);
    }

    #[Route('/api/niveauscolaire/{id}', name: 'Show_niveauscolaire',methods:['GET'])]
    public function ShowNiveauScolaire( int $id,EntityManagerInterface $entityManager): JsonResponse
    {
        $niveauScolaire = $entityManager->getRepository(NiveauScolaire::class)->find($id);

        if (!$niveauScolaire) {
            return $this->json("Aucun niveau scolaire trouvé de l'identifiant $id", 404);
        }
        $data = [
            'id' => $niveauScolaire->getId(),
            'code' => $niveauScolaire->getCode(),
            'libelle' => $niveauScolaire->getLibelle(),
            'description' => $niveauScolaire->getDescription(),
        ];
        return $this->json($data);
    }

    #[Route('/api/modifier/niveauscolaire/{id}', name: 'Modifeir_niveauscolaire',methods:['PUT'])]
    public function ModifierNiveauScolaire( int $id,EntityManagerInterface $entityManager,Request $request): JsonResponse
    {
        $request_data = json_decode($request->getContent(), true);
    
        $niveauScolaire = $entityManager->getRepository(NiveauScolaire::class)->find($id);
    if (!$niveauScolaire) {
        return $this->json(
            [
                'code' => 404,
                'message' => 'Aucun module trouvé pour l"identifiant'  . $id, 
            ], 
            404
        );
    }
    $niveauScolaire->setCode($request_data['code']);
    $niveauScolaire->setLibelle($request_data['libelle']);
    $niveauScolaire->setDescription($request_data['description']);
    $entityManager->flush();

    $data = [
        'id' => $niveauScolaire->getId(),
        'code' => $niveauScolaire->getCode(),
        'libelle' => $niveauScolaire->getLibelle(),
        'description' => $niveauScolaire->getDescription(),
    ];
    return $this->json($data);
}

#[Route('api/niveauscolaire/supprimer/{id}', name: 'niveauscolaire_delete', methods:['delete'] )]
    public function delete(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
         $niveauScolaire = $entityManager->getRepository(NiveauScolaire::class)->find($id);
        if (!$niveauScolaire) {
            return $this->json('Aucun module trouvé pour l"identifiant'  . $id, 404);
        }
        $entityManager->remove($niveauScolaire);
        $entityManager->flush();
   
        return $this->json('Suppression réussie avec succès l"identifiant ' . $id);

    }
}
