<?php

namespace App\Controller;

use Symfony\Component\Security\Core\User\UserInterface;


use App\Entity\User;
use App\Entity\Profil;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api")
 */

class SecurityController extends AbstractController
{

    /** 
     * @Route("/register", name="register", methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $values = json_decode($request->getContent());
        if (isset($values->username, $values->password)) {
            $user = new User();
            $user->setUsername($values->username);
            $mdp = "12345678";
            $user->setPassword($passwordEncoder->encodePassword($user, $mdp));

            // recuperer id profil
            $repos = $this->getDoctrine()->getRepository(Profil::class);
            $profils = $repos->find($values->profil);
            $user->setProfil($profils);

            $role = [];
            if ($profils->getLibelle() == "admin") {
                $role = (["ROLE_ADMIN"]);
            } elseif ($profils->getLibelle() == "user") {
                $role = (["ROLE_USER"]);
            } elseif ($profils->getLibelle() == "caissier") {
                $role = (["ROLE_CAISSIER"]);
            } elseif ($profils->getLibelle() == "superadmin") {
                $role = (["ROLE_SUPER_ADMIN"]);
            }

            $user->setRoles($role);
            $user->setNomcomplet($values->$nomcomplet);
            $user->setTelephone($values->telephone);
            $block = "debloquer";
            $user->setStatut($block);



            // recuperer l'id du partenaire
            $repo = $this->getDoctrine()->getRepository(Partenaire::class);
            $partenaires = $repo->find($values->partenaire);

            $user->setPartenaire($partenaires);



            $entityManager->persist($user);
            $entityManager->flush();

            $data = [
                'status1' => 201,
                'message1' => 'L\'utilisateur a été créé'
            ];

            return new JsonResponse($data, 201);
        }
        $data = [
            'status2' => 500,
            'message2' => 'Vous devez renseigner les clés username et password'
        ];
        return new JsonResponse($data, 500);
    }


    /** 
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request)
    {
        $user = $this->getUser();
        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles()
        ]);
    }

    /**
     * @Route("/users/bloquer", name="userBlock", methods={"GET","POST"})
     * @Route("/users/debloquer", name="userDeblock", methods={"GET","POST"})
     */

    public function userBloquer(Request $request, UserRepository $userRepo, EntityManagerInterface $entityManager)
    {
        $values = json_decode($request->getContent());
        if (isset($values->username, $values->password)) {
            $user = new User();
            $user->setUsername($values->username);
            $mdp = "1234556";
            $user->setPassword($mdp);

            $repos = $this->getDoctrine()->getRepository(Profil::class);
            $profils = $repos->find($values->profil);
            $prof = $user->setProfil($profils);

            $role = [];
            if ($prof == "1") {
                $role = ["ROLE_ADMIN"];
            } elseif ($prof == "2") {
                $role = ["ROLE_SUPER_ADMIN"];
            } elseif ($prof == "3") {
                $role = ["ROLE_CAISSIER"];
            } elseif ($prof == "4") {
                $role = ["ROLE_USER"];
            }

            $user->setRoles($role);
            $user->setNomcomplet($values->$nomcomplet);
            $user->setTelephone($values->telephone);
            $block = "debloquer";
            $user->setStatut($block);


            $repo = $this->getDoctrine()->getRepository(Partenaire::class);
            $partenaires = $repo->find($values->partenaire);

            $user->setPartenaire($partenaires);


            $entityManager->persist($user);
            $entityManager->flush();

            $data = [
                'status1' => 201,
                'message1' => 'L\'utilisateur a été créé'
            ];

            return new JsonResponse($data, 201);
        }
        $data = [
            'status' => 500,
            'message' => 'Vous devez renseigner les clés username et password'
        ];
        return new JsonResponse($data, 500);
    }
}
