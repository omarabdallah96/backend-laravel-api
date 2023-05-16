<?php

/**
 * Created by PhpStorm.
 * User: olufisayoafolayan
 * Date: 2019-03-18
 * Time: 16:23
 */

namespace App\Helpers;

use Illuminate\Support\Facades\Http;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Helper
{

    /**
     * @param $url_params
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function NewsOrgUrlApi($seachQuery, $authors = [], $categories = [])
    {



        $url = config('app.NEWS_ORG_URL') . 'everything?q=' . urlencode($seachQuery) . '&apiKey=' . config('app.NEWS_API_KEY');

        try {
            $response = Http::get($url);


            if (!$response->ok()) {
                return array();
            }


            $articles = $response->json()['articles'];


            $filtered_articles = array();

            foreach ($articles as $article) {
                $filtered_article = array(
                    'title' => $article['title'],
                    'description' => $article['description'],
                    'image' => $article['urlToImage'] ?? "https://img.icons8.com/ios/50/no-image.png",
                    'api_source' => 'NEWS_ORG_URL',
                    'full_post' => $article['url'],

                );
                array_push($filtered_articles, $filtered_article);
            }

            return $filtered_articles;
        } catch (HttpException $e) {
            // Handle exception as needed
            return array();
        }
    }



    public function CallNewsCatcher($seachQuery, $autheres = [], $categories = [])
    {





        $api_key = config('app.NEWS_CATCHER_API_KEY');
        $url = 'https://api.newscatcherapi.com/v2/search';



        try {
            $response = Http::withHeaders([
                'x-api-key' => $api_key,
            ])->get($url, [
                'q' => $seachQuery,
                'lang' => 'en',
                'topic' => [$categories]
                // "authors"=>"Devdiscourse News Desk"
            ]);



            if ($response->ok()) {
                $data = $response->json();

                return $data;
                // Do something with the response data
            } else {

                return array();

                // Handle the error
            }
        } catch (HttpException $e) {
            // Handle exception as needed
            return array();
        }
    }


    public function NewYorkTimesAPi($seachQuery, $authors = null, $categories = null)
    {

        $url = 'https://api.nytimes.com/svc/search/v2/articlesearch.json';
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get($url, [
            'api-key' => 'WqZo0GCj1pDxv2g0YDW1kuK1yIPGpddb',
            'q' => $seachQuery

        ]);

        if ($response->ok()) {
            $data = $response->json();
            $articles = $data['response']['docs'];

            $results = [];
            foreach ($articles as $article) {
                $result = [
                    'title' => $article['headline']['main'],
                    'description' => $article['abstract'],
                    'image' => "https://img.icons8.com/ios/50/no-image.png",
                    'api_source' => 'nytimes',
                    'full_post' => $article['web_url'],
                    'pub_date' => $article['pub_date']
                ];
                if (isset($article['multimedia'][0]['url'])) {
                    $result['image'] = 'https://www.nytimes.com/' . $article['multimedia'][0]['url'];
                }
                $results[] = $result;
            }
            return $results;
        } else {
            return [];
        }
    }
}
