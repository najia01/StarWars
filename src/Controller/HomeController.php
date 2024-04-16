<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(HttpClientInterface $httpClient): Response
    {
        $personnages = $httpClient->request(
            'GET',
            'https://swapi.dev/api/people/'

        );
        return $this->render('home/index.html.twig', [
            'personnages' => $personnages->toArray()['results'],
        ]);
    }
    

    #[Route('/personnage/{id}', name: 'app_personnage', requirements: ['id' => '\d+'])]
    public function personnage(int $id, HttpClientInterface $httpClient): Response
    {
      
     $personnage = $httpClient->request(
     'GET',
     'https://swapi.py4e.com/api/people/'.$id
     );

     return $this->render('home/personnage.html.twig', [
     'personnage' => $personnage->toArray(),
     ]);
    }
}
