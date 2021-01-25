<?php

namespace App\Controller;

use App\Form\ProfileFormType;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile_index")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function index(Request $request, UserRepository $userRepository, FileUploader $fileUploader): Response
    {
        $user = $userRepository->findOneBy([
            'email' => $this->getUser()->getUsername()
        ]);

        $form = $this->createForm(ProfileFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData();
            $fileName = null;
            $pathFolder = $user->getEmail();

            if ($file) {
                $fileName = $fileUploader->upload($pathFolder, $file);
            }

            if ($user->getImage()) {
                $fileUploader->delete($pathFolder . '/'. $user->getImage());
            }

            $user->setFirstName($form->get('firstName')->getData());
            $user->setLastName($form->get('lastName')->getData());
            $user->setBirthday($form->get('birthday')->getData());
            $user->setImage($fileName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirect('/profile');
        }

        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
