<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/hello", name="hello")
     */
    public function hello()
    {
        return $this->render('test/hello.html.twig');
    }
}
