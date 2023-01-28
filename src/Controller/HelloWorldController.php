<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends AbstractController
{
    #[Route('/helloworld', name: 'app_hello_world')]
    public function index(): Response
    {
        $name = "Truc";
        return $this->render('HelloWorld.html.twig', [
            'name' => $name,
        ]);
    }
}
