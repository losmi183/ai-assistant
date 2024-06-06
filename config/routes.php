<?php

$r->addRoute('GET', '/users', 'App\Controllers\UserController@index');
$r->addRoute('GET', '/user/{id:\d+}', 'App\Controllers\UserController@show');
$r->addRoute('GET', '/articles/{title}', 'App\Controllers\ArticleController@show');
