<?php

namespace App\Controller;

use App\Entity\Etudiant;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EtudiantController extends AbstractController
{
    #[Route('/etudiant', name: 'app_etudiant')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/EtudiantController.php',
        ]);
    }

    #[Route('/api/etudiants', name: 'tous_etudiant')]
    public function etudiantAll(ManagerRegistry $doctrine): JsonResponse
    {
        $etudiants = $doctrine->getRepository(Etudiant::class)->findAll();;
        $data = [];
        foreach ($etudiants as $etudiant) {
           $data[] = [
               'id' =>$etudiant->getId(),
               'nom' =>$etudiant->getNom(),
               'prenom' =>$etudiant->getPrenom(),
               'dateNaissance' =>$etudiant->getDateNaissance()->format('Y-m-d'),
               'motivation' =>$etudiant->getMotivation(),
           ];
    }
        return $this->json($data);  
    }

    #[Route('/api/ajouter/etudiant', name: 'ajouter_etudiant',methods:['POST'])]
    public function createEtudiant( Request $request,EntityManagerInterface $entityManager): JsonResponse
    {
       $request_data = json_decode($request->getContent(),true);

       $etudiant = new Etudiant();
       $etudiant ->setNom($request_data['nom']);
       $etudiant ->setPrenom($request_data['prenom']);
       $etudiant ->setDateNaissance(new \DateTime ($request_data['dateNaissance']));
       $etudiant ->setMotivation($request_data['motivation']);

       $entityManager->persist($etudiant);
       $entityManager->flush();
       
       $data = [
        'id' =>$etudiant->getId(),
               'nom' =>$etudiant->getNom(),
               'prenom' =>$etudiant->getPrenom(),
               'dateNaissance' =>$etudiant->getDateNaissance()->format('Y-m-d'),
               'motivation' =>$etudiant->getMotivation(),
    ];

    return $this->json($data);
    }
}
