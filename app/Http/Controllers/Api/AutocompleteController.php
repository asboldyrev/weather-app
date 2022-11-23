<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AutocompleteController extends Controller
{
    public function search(Request $request) {
        //$search = $request->input('query');
        //$key_cache = 'autocomplete-' . md5(json_encode($search));

        //$content = Cache::get($key_cache);

        //if(!$content) {
        //    $client = new Client([
        //        'base_uri' => 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/',
        //        'headers' => [
        //            "Content-Type" => "application/json",
        //            "Accept" => "application/json",
        //            "Authorization" => "Token " . env('DADATA_TOKEN'),
        //        ],
        //    ]);

        //    $response = $client->post('suggest/address', [
        //        'json' => [
        //            'query' => $search,
        //            'count' => 7,
        //        ]
        //    ]);

        //    $body = $response->getBody();
        //    $content = $body->getContents();

        //    Cache::add($key_cache, $content, 36000);
        //}

        //return response($content);
    }
}
