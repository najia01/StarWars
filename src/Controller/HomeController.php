<?php

namespace App\Controller;

use App\Service\StarWarsApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends AbstractController
{

    public function __construct(private readonly StarWarsApiService $starWarsApiService)
    {
        
    }
    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        $page = $request->query->getInt('page', 1); // Get 'page' parameter from the query, default is 1
        return $this->render('home/index.html.twig', [
            'personnages' => $this->starWarsApiService->getPersonnages($page),
            'currentPage' => $page,
            'nextPage' => $page + 1,
            'prevPage' => $page > 1 ? $page - 1 : null
        ]);
    }
    

    #[Route('/personnage/{id}', name: 'app_personnage', requirements: ['id' => '\d+'])]
    public function personnage(int $id): Response
    {
      
    

     return $this->render('home/personnage.html.twig', [
     'personnage' =>$this->starWarsApiService->getPersonnage($id),
     ]);
    }


    #[Route('/planets', name: 'app_planets')]
public function planets(Request $request): Response
{
    $page = $request->query->getInt('page', 1);
    $planetsData = $this->starWarsApiService->getPlanets($page);

    return $this->render('home/planets.html.twig', [
        'planets' => $planetsData['results'],
        'currentPage' => $page,
        'nextPage' => $page + 1,
        'prevPage' => $page > 1 ? $page - 1 : null
    ]);
}

}
