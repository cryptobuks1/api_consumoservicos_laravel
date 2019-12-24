<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterApiController;
use App\models\Post;

class PostApiController extends MasterApiController
{
    //Variável responsável por armazenar o nome da model que está sendo referenciada
    protected $model;

    //Variável responsavel por armazenar o nome do diretório público
    protected $path = 'post';

    //Variável responsavel por armazenar o nome da imagem de capa do filme
    protected $upload = 'image';

    //Variável responsável por armazenar os valores de tamanho vertical
    protected $width = 800;

    //Variável responsável por armazenar os valores de tamanho horizontal
    protected $height = 533;

    //Construtor do noso objeto/classe "Cliente"
    public function __construct(Post $posts, Request $request)
    {
        $this->model = $posts;
        $this->request = $request;
    }
}
