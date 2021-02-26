<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurAgenceController extends AbstractController
{
    /**
     * @Route("/utilisateur/agence", name="utilisateur_agence")
     */
    public function index(): Response
    {
        return $this->render('utilisateur_agence/index.html.twig', [
            'controller_name' => 'UtilisateurAgenceController',
        ]);
    }
}
