<?php

namespace App\Controller;

use App\Entity\Compte;
use ApiPlatform\Core\Api\IriConverterInterface;
use App\Repository\CompteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use function dd;
use function gmdate;

class CompteController extends AbstractController
{
    /**
     * @Route(
     * name="charger_compte",
     * path="api/admin/compte/{id}",
     * methods={"PUT"},
     * defaults={
     * "_controller"="\app\Controller\CompteController::charger_compte",
     * "_api_resource_class"=Compte::class,
     * "_api_item_operation_name"="charger_compte"
     * }
     * )
     */
    public function charger_compte(int $id , Request $request,EntityManagerInterface $entity,SerializerInterface $serialize,CompteRepository $compte)
    {

        //dd($request);
        $Compte_json = $request->getContent();
        $compteContent=json_decode($Compte_json, true) ;
       // dd($user) ;
        //$User = $serialize ->normalize($User_json,true);
        //dd($User) ;
        $sommeAjoute = $compteContent['nouveausolde'] ;
        //dd($sommeAjoute);
        $ancienSomme = $compte -> find($id) ;
        $norm = $ancienSomme->getSolde() ;
       // $norm = $serialize ->normalize($ancienSomme,true);
      //dd($norm) ;
        $total = $norm + $sommeAjoute ;
        //dd($total) ;
       // dd($norm) ;
        $ancienSomme->setSolde($total);
        //dd($ancienSomme) ;
        $entity -> persist($ancienSomme);
        $entity -> flush();
        return $this->json("succes",201);
    }

}
