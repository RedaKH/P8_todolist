<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserUpdateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Repository\UserRepository;

class UserController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/user", name="user_list")
     */
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('user/listuser.html.twig', [
            'users' => $users
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
        return $this->render('user/makeuser.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/users/{id}/edit", name="user_edit")
     */
    public function updateUser(Request $request,User $user,$id,UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $form = $this->createForm(UserType::class,$user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->getPlainPassword()) {
                $user->setPassword(
                    $userPasswordHasherInterface->hashPassword($user,$user->getPlainPassword())
                );
            }
                        
        

            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('msg', 'Votre profil a bien été modifié');


            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/update_profile.html.twig',['form'=>$form->createView(),'user'=>$user]); 
    }
}