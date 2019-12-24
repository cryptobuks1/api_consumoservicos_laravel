<?php

//Criado automaticamente pelo Laravel
namespace App\Http\Controllers\Api;

//Criado automaticamente pelo Laravel
use Illuminate\Http\Request;
use App\Http\Controllers\MasterApiController;

//Para usarmos o nosso método chamado "models/Cliente"
use App\Models\Movie;


class MovieApiController extends MasterApiController
{
    //Variável responsável por armazenar o nome da model que está sendo referenciada
    protected $model;

    //Variável responsavel por armazenar o nome do diretório público
    protected $path = 'movies';

    //Variável responsavel por armazenar o nome da imagem de capa do filme
    protected $upload = 'image';

    //Variável responsável por armazenar os valores de tamanho vertical
    protected $width = 177;

    //Variável responsável por armazenar os valores de tamanho horizontal
    protected $height = 236;

    //Variável responsável por armazenar os valores emtre as paginações de 20 em 20
    protected $paginacao = 20;

    //Construtor do noso objeto/classe "Cliente"
    public function __construct(Movie $movies, Request $request)
    {
        $this->model = $movies;
        $this->request = $request;
    } 

}
