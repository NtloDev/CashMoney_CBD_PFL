<?php

namespace App\Controller;

use App\Entity\Transaction;
use ApiPlatform\Core\Api\IriConverterInterface;
use App\Repository\CompteRepository;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use function dd;
use function gmdate;
use function json_decode;
use function mt_rand;

class TransactionController extends AbstractController
{
    /**
     * @Route(
     * name="create_transaction",
     * path="api/admin/transaction",
     * methods={"POST"},
     * defaults={
     * "_controller"="\app\Controller\TransactionController::create_transaction",
     * "_api_resource_class"=Transaction::class,
     * "_api_collection_operation_name"="create_transaction"
     * }
     * )
     */
    public function create_transaction(Request $request,EntityManagerInterface $entity,SerializerInterface $serialize)
    {

        //dd($request);
        $Transaction_json = $request->getContent();
        $Transaction_json=json_decode($Transaction_json, true) ;
        $montant = $Transaction_json['montant'] ;
        $transaction = $serialize ->denormalize($Transaction_json,"App\Entity\Transaction",true);
        $random =  mt_rand(1, 559009) ;
        //dd($random) ;
        $transaction->setCode($random) ;
        if ($montant > 0 && $montant <= 5000){
            $transaction->setFrais(425) ;
            //dd($montant);
        }
        elseif ($montant > 5000 && $montant <= 10000 ){
            $frais = 850 ;
            $transaction->setFrais(850) ;

        }
        elseif ($montant > 10000 && $montant <= 15000 ){
            $frais = 1270 ;
            $transaction->setFrais(1270) ;
        }
        elseif ($montant > 15000 && $montant <= 20000 ){
            $frais = 1695 ;
            $transaction->setFrais(1695) ;
        }
        elseif ($montant > 20000 && $montant <= 50000 ){
            $frais = 2500 ;
            $transaction->setFrais(2500) ;
        }
        elseif ($montant > 50000 && $montant <= 60000 ){
            $frais = 3000 ;
            $transaction->setFrais(3000) ;
        }
        elseif ($montant > 60000 && $montant <= 75000 ){
            $frais = 4000 ;
            $transaction->setFrais(4000) ;
        }
        elseif ($montant > 75000 && $montant <= 120000 ){
            $frais = 5000 ;
            $transaction->setFrais(5000) ;
        }
        elseif ($montant > 120000 && $montant <= 150000 ){
            $frais = 6000 ;
            $transaction->setFrais(6000) ;
        }
        elseif ($montant > 150000 && $montant <= 200000 ){
            $frais = 7000 ;
            $transaction->setFrais(7000) ;
        }
        elseif ($montant > 200000 && $montant <= 250000 ){
            $frais = 8000 ;
            $transaction->setFrais(8000) ;
        }
        elseif ($montant > 250000 && $montant <= 300000 ){
            $frais = 9000 ;
            $transaction->setFrais(9000) ;
        }
        elseif ($montant > 300000 && $montant <= 400000 ){
            $frais = 12000 ;
            $transaction->setFrais(12000) ;
        }
        elseif ($montant > 400000 && $montant <= 750000 ){
            $frais = 15000 ;
            $transaction->setFrais(15000) ;
        }
        elseif ($montant > 750000 && $montant <= 900000 ){
            $frais = 22000 ;
            $transaction->setFrais(22000) ;
        }
        elseif ($montant > 900000 && $montant <= 1000000 ){
            $frais = 25000 ;
            $transaction->setFrais(25000) ;
        }
        elseif ($montant > 1000000 && $montant <= 1125000 ){
            $frais = 27000 ;
            $transaction->setFrais(27000) ;
        }
        elseif ($montant > 1125000 && $montant <= 1400000 ){
            $frais = 30000 ;
            $transaction->setFrais(30000) ;
        }
        elseif ($montant > 1400000 && $montant <= 2000000 ){
            $frais = 30000 ;
            $transaction->setFrais(30000) ;
        }
        elseif ($montant > 2000000){
            $frais = $montant * 0.02 ;
            $fraiss = $montant * 0.02 ;
            //dd($frais) ;
            $transaction->setFrais($fraiss) ;
        }
        $fraisEtat = $frais * 0.04 ;
        $fraisSys = $frais * 0.03 ;
        $fraisDepot = $frais * 0.01 ;
        $fraisRetrait = $frais * 0.02 ;
        $transaction->setFraisEtat($fraisEtat) ;
        $transaction->setFraisSystem($fraisSys) ;
        $transaction->setFraisOperateurDepot($fraisDepot) ;
        $transaction->setFraisOperateurRetrait($fraisRetrait) ;
        //dd($transaction) ;
        $entity -> persist($transaction);
        $entity -> flush();
        return $this->json("succes",201);
    }

    /**
     * @Route(
     * name="transaction_retrait",
     * path="api/admin/transaction/{id}",
     * methods={"PUT"},
     * defaults={
     * "_controller"="\app\Controller\TransactionController::transaction_retrait",
     * "_api_resource_class"=Transaction::class,
     * "_api_item_operation_name"="transaction_retrait"
     * }
     * )
     */
    public function transaction_retrait(int $id , TransactionRepository $transactionDepot, Request $request,EntityManagerInterface $entity,SerializerInterface $serialize )
    {
        $depot = $transactionDepot -> find($id) ;
        $beneficiaireCNI = $depot->getBeneficiaireCNI() ;
        //dd($beneficiaireCNI) ;
       // dd($request);
        $Transaction_json = $request->getContent();
        $Transaction_json=json_decode($Transaction_json, true) ;
        $cnitest = $Transaction_json['beneficiaireCNITest'] ;
        //dd($cnitest , $beneficiaireCNI) ;

        if ($cnitest == $beneficiaireCNI){
            $depot->setRetrait(true) ;
            //dd($depot) ;
            $entity -> persist($depot);
            $entity -> flush();
            return $this->json("succes",201);
        }

       else {
           return $this->json("bad credentials",403);
       }
    }

}
