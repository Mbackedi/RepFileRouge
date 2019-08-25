<?php

namespace App\Controller;

use Dompdf\Dompdf;
use App\Entity\Tarif;
use App\Entity\Envoyeur;
use App\Form\EnvoyeurType;
use App\Entity\Transaction;
use App\Entity\Beneficiaire;
use App\Form\TransactionType;
use App\Form\BeneficiaireType;
use App\Form\DestinataireType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TransactionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api")
 */
class TransactionController extends AbstractController
{
   

    /**
     * @Route("/new", name="transaction_new", methods={"POST"})
    */
    public function new (Request $request,  EntityManagerInterface $entityManager, ValidatorInterface $validator, SerializerInterface $serializer)
    {   //ENVOYEUR
        $envoyeur = new Envoyeur();
        $form = $this->createForm(EnvoyeurType::class, $envoyeur);
        $data = $request->request->all();
        $form->handleRequest($request);
        $form->submit($data);
        if($form->isSubmitted()){


            //BENEFICIAIRE
            $beneficiaire = new Beneficiaire();
            $form = $this->createForm(BeneficiaireType::class, $beneficiaire);
            $data = $request->request->all();
            $form->handleRequest($request);
            $form->submit($data);
            
            //TRANSACTION
            $transaction = new Transaction();
            $form = $this->createForm(TransactionType::class, $transaction);
            $form->handleRequest($request);
            $data = $request->request->all();
            $form->submit($data);

            $transaction->setDatedenvoie(new \DateTime());
            // generer le code
            $code=rand(10000000,99999999);
            $transaction->setCode($code);
            //recuperer l'id du caissier
            $user=$this->getUser();
            $transaction->setCaissier($user);
            // recuperer l'id de l'envoyeur
            $transaction->setEnvoyeur($envoyeur);
            // recuperer l'id du recepteur
            $transaction->setBeneficiaire($beneficiaire);
            // recuperer valeur du frais 
            $repository=$this->getDoctrine()->getRepository(Tarif::class);
            $com=$repository->findAll();
            $montant=$transaction->getMontant();
            //verifier montant dispo
            $comptes=$this->getUser()->getCompte();

            $comptes->getSolde();
         
            if($transaction->getMontant()>= $comptes->getSolde()){
                return $this->json([
                    'message1'=> 'Votre solde('.$comptes->getSolde().' ) ne vous permet pas d\'effectuer cette transaction'
                ]);
            }

            // verifier les frais  correspondant au montant
            foreach($com as $values){
                $values->getBorneInf();
                $values->getBorneSup();
                $values->getValeur();
                if($montant >= $values->getBorneInf() && $montant <= $values->getBorneSup()){
                    $valeur=$values->getValeur();
                }
            }

            $transaction->setFrais($valeur);

            $sup = ($valeur  * 40) / 100;
            $parte = ($valeur * 20) / 100;
            $etat = ($valeur * 30) / 100;
           
            
            $transaction->setCommissionsup($sup);
            $transaction->setCommissionparte($parte);
            $transaction->setCommissionetat($etat);
            $transaction->setNumerotransacion(rand(11111111,9999999));
            $total=$montant+$valeur;
            $comptes->setSolde($comptes->getSolde() - $montant+$sup);
    
            $transaction->setTotal($total);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($envoyeur);
            $entityManager->persist($beneficiaire);
            $entityManager->persist($transaction);
            $entityManager->flush();


            $data = [
                '$status' => 201,
                'message' => 'ENVOIE REUSSIE'
            ];
            return new JsonResponse($data, 201);
        }
        $data = [
            '$status' => 500,
            'message' => 'VEUILLEZ VERIFIER LA SAISIE'
        ];
        return new JsonResponse($data, 500);
    }



    /**
     * @Route("/document", name="document")
     */

     public function index(){
        // Configurez Dompdf selon vos besoins
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instancier Dompdf avec nos options
        $dompdf = new Dompdf($pdfOptions);

        // Récupère le code HTML généré dans notre fichier twig
        $html = $this->renderView('transaction/index.html.twig', [
            'title' => "Welcome to our PDF Test"
        ]);

        // Charger du HTML dans Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        //Exporter le PDF généré dans le navigateur (vue intégrée)
        $dompdf->stream("testpdf.pdf", [
            "Attachment" => false
        ]);
     }



    /**
     * @Route("/{id}", name="transaction_show", methods={"GET"})
     */
    public function show(Transaction $transaction): Response
    {
        return $this->render('transaction/show.html.twig', [
            'transaction' => $transaction,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="transaction_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Transaction $transaction): Response
    {
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('transaction_index');
        }

        return $this->render('transaction/edit.html.twig', [
            'transaction' => $transaction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="transaction_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Transaction $transaction): Response
    {
        if ($this->isCsrfTokenValid('delete' . $transaction->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($transaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('transaction_index');
    }
}
