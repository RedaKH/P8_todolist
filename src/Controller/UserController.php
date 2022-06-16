<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user_list")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/user_create", name="user_create")
     */
    public function registerUser(Request $request,UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(array('ROLE_USER'));
            if ($user->getPlainPassword()) {
                $user->setPassword(
                    $userPasswordHasherInterface->hashPassword($user,$user->getPlainPassword())
                );
            }


            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success', 'Votre compte a bien été enregistré');
            return $this->redirectToRoute('user_list');

        }
        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/users/{id}/edit", name="user_edit")
     */
    public function updateUser(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class,$user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                        
        

            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('msg', 'Votre profil a bien été modifié');


            return $this->redirectToRoute('app_task');
        }

        return $this->render('user/update_profile.html.twig',['form'=>$form->createView()]); 
    }
}
