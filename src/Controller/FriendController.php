<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class FriendController extends AbstractController
{
    const ROW_PER_PAGE = 10;

    /**
     * @Route("/friends", name="friend_friends")
     */
    public function index(): Response
    {
        return $this->render('friend/index.html.twig');
    }

    /**
     * @Route("/friends/findAllPeople", name="friend_findAll")
     */
    public function findAllPeople(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAllPeoples($this->getUser()->getUsername(), self::ROW_PER_PAGE);

        $countUsers = count($userRepository->findAll());

        $html = $this->renderView('friend/usersList.html.twig', [
            'users' => $users,
        ]);

        return new JsonResponse([
            'html' => $html,
            'message' => 'Success!',
            'rowPerPage' => self::ROW_PER_PAGE,
            'countUsers' => $countUsers - 1
        ], 200);
    }

    /**
     * @Route("/friends/findByFirstName", name="friend_findByFirstName")
     */
    public function findByFirstName(Request $request, UserRepository $userRepository): Response
    {
        if ($request->isMethod('POST')) {
            $firstName = $request->request->get("firstName");
            $offset = $request->request->get("offset");

            $users = $userRepository->findByFirstName($firstName, $this->getUser()->getUsername(), self::ROW_PER_PAGE, $offset);

            $html = $this->renderView('friend/usersList.html.twig', [
                'users' => $users,
            ]);

            return new JsonResponse([
                'html' => $html,
                'message' => 'Success!',
            ], 200);
        }

        return new JsonResponse([
            'message' => 'Error!'
        ], 400);
    }
}
