<?php
//Rota padrão gerada automaticamente pelo Laravel - Não vou usar isso - Vou criar minhas próprias rotas
//Gerado par ao arquivo controller->"ClienteApiController_backup"
//Route::get('clientes', 'Api\ClienteApiController@index');

//ROTA DE LOGIN - AUTENTICAÇÃO VIA TOKEN GERADO PELO JWT - JSON WEB TOKEN
$this->post('login', 'Auth\AuthenticateController@authenticate');
$this->post('logout', 'Auth\AuthenticateController@logout');
$this->post('login-refresh', 'Auth\AuthenticateController@refreshToken');
$this->get('me', 'Auth\AuthenticateController@getAuthenticatedUser');

//Grupo de rotas que necessitam de privilégios para poderem acessar as funcinalidades da API
//$this->group(['namespace' => 'Api', 'middleware' => 'auth:api'], function () { //Exige autenticação
//$this->group(['namespace' => 'Api', /* 'middleware' => 'auth:api' */], function () { //Não exige autenticação

$this->group(['namespace' => 'Api', /* 'middleware' => 'auth:api' /*/], function () {
    //ROTA CATEGORY
    $this->apiResource('posts', 'PostApiController');    
});
