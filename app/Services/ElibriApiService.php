<?php
namespace App\Services;
use GuzzleHttp\Client;

class ElibriApiService {
    protected $client;

    public function __construct() {
        $this->client = new Client([
            'base_uri' => 'https://www.elibri.com.pl/api/v1/',
            'auth' => [env('ELIBRI_API_LOGIN'), 
		       env('ELIBRI_API_PASSWORD')]
        ]);
    }

public function getAllBooks() {
    $response = $this->client->request('POST', 'queues/meta/pop', [
        'auth' => [env('ELIBRI_API_LOGIN'), env('ELIBRI_API_PASSWORD'), 'digest'],
        'form_params' => [
        'count' => 50,
        //    'testing' => 1
        ]
    ]);
    $body = $response->getBody()->getContents();
    return simplexml_load_string($body);
}

public function refillQueue() {
    $this->client->request('POST', 'queues/refill_all', [
        'auth' => [env('ELIBRI_API_LOGIN'), env('ELIBRI_API_PASSWORD'), 'digest']
    ]);
}



public function getPublishers() {
    $response = $this->client->request('GET', 'publishers');
    return json_decode($response->getBody()->getContents());
}



    
}
