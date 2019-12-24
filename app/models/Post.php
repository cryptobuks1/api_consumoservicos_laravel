<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    //Método com array/lista para recuperar os dados
    protected $fillable = [
        //Atributos do nosso objeto
        'id',
        'title',
        'userId',
        'body'
    ];

    //Método para atribuir uma validação ou regras para POST/INSERT  -  'CAMPO' => 'OBRIGATÓRIO/TIPO_DADOS/SE_É_ÚNICO'
    public function rules(){
        //Array/lista com todos os dados
        return [
            //Atributo nome é obrigatório
            'title' => 'required'
        ];
    }

}
