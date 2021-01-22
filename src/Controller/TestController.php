<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class TestController extends AbstractController
{
    /**
     * @Route("/hello", name="test_hello")
     */
    public function hello(): Response
    {
        return $this->render('test/hello.html.twig');
    }
}
