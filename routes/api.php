<?php

$router->post('weather', 'WeatherController@show');

$router->post('autocomplete', 'AutocompleteController@search');
