<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class TMDBApiController extends AbstractController
{
    #[Route('/api/tmdb/search', name: 'tmdbapi_fetchmovie', methods: ['GET'])]
    public function getMovieDetail(Request $request, HttpClientInterface $client): JsonResponse {
        
       $query = $request->query->get('q', '');
        if (!$query) {
            return new JsonResponse(['results' => []]);
        }

        $api_key = $_ENV['TMDB_API_KEY'];

        $response = $client->request('GET', 'https://api.themoviedb.org/3/search/movie', [
            'query' => [
                'api_key' => $api_key,
                'query' => $query,
                'language' => 'fr-FR',
            ],
        ]);

        $fetchedData = $response->toArray();

        return new JsonResponse(['results' => $fetchedData['results'] ?? []]);
    }

    #[Route('/api/tmdb/searchmoviegenre', name: 'tmdbapi_fetchmoviegenre', methods: ['GET'])]
    public function getMovieGenre(HttpClientInterface $client): JsonResponse {
        
        $api_key = $_ENV['TMDB_API_KEY'];

        $response = $client->request('GET', 'https://api.themoviedb.org/3/genre/movie/list', [
            'query' => [
                'api_key' => $api_key,
                'language' => 'fr-FR',
            ],
        ]);

        $fetchedData = $response->toArray();

        return new JsonResponse(['genres' => $fetchedData['genres'] ?? []]);
    }
}