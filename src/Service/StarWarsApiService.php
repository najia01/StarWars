<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class StarWarsApiService
{
    private const BASE_URL = 'https://swapi.py4e.com/api/';
    private const ITEM = 'ITEM';
    private const COLLECTION = 'COLLECTION';

    public function __construct(
        private readonly HttpClientInterface $httpClient
    )
    {
    }

    public function getPersonnages(int $page = 1) : array {
        return $this->makeRequest('people', null, $page);
    }
    
    public function getPersonnage(int $id) : array {
        return $this->makeRequest('people', $id);
    }
    
    // Ajout d'une méthode pour récupérer les planètes
    public function getPlanets(int $page = 1) : array {
        return $this->makeRequest('planets', null, $page);
    }
    

    private function makeRequest(string $resourceType, ?int $id = null, ?int $page = null): array {
        // Construire l'URL en fonction du type de ressource et de l'ID éventuel
        $url = $id ? self::BASE_URL . $resourceType . '/' . $id : self::BASE_URL . $resourceType;
    
        // Préparation des paramètres de requête
        $params = [];
        if ($page) {
            $params['query'] = ['page' => $page];
        }
    
        // Effectuer la requête HTTP
        $response = $this->httpClient->request('GET', $url, $params);
    
        // Retourner la réponse sous forme de tableau
        return $response->toArray();
    }
    
    
}
