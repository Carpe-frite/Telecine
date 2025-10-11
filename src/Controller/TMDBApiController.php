<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TMDBApiController extends AbstractController
{
    #[Route('/api/tmdb/fetchmovie', name: 'tmdbapi_fetchmovie', methods: ['GET'])]
    public function getMovieDetail(Request $request, HttpClientInterface $client): JsonResponse {
        
        $query = $request->query->get('q', '');
        return new JsonResponse(['results' => []]);

        $api_key = $_ENV['TMDB_API_KEY'];
        $api_response = $client->request('GET', 'https://api.themoviedb.org/3/search/movie', ['query' => [
            'api_key' => $api_key,
            'query' => $query,
            'language' => 'fr-FR'
        ]]);

        return new JsonResponse($response->toArray());
    }
}