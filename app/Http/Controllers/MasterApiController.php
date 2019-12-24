<?php

namespace App\Http\Controllers;

//Criado automaticamente pelo Laravel
use Illuminate\Http\Request;

//Copiados diretamento do arquivo "http/controller/controller.php"
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

//Para uso exclusivo da biblioteca "intervention/image" para UPLOAD DE ARQUIVOS DE IMAGEM
use Intervention\Image\ImageManagerStatic as Image;

//Para uso do nosso STORAGE para atualizar o perfil do usuário, entre outras apossibilidades
use Illuminate\Support\Facades\Storage;

class MasterApiController extends BaseController
{

    //Copiados diretamento do arquivo "http/controller/controller.php"
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Metodo SELECT ALL
    public function index()
    {
        //Seleciona todos os registros cadastrados SEM A PAGINAÇÃO
        $data = $this->model->all();
        
        //Seleciona todos os clientes cadastrados COM A PAGINAÇÃO
        //$data = $this->model->paginate(10);

        //"dd" é pra decorara variável "$data"
        //dd($data);

        //Selecionando os dados propriamente dito
        return response()->json($data);
    }

    //Método CREATE
    public function store(Request $request)
    {
        //Aplicando regras de validação
        $this->validate($request, $this->model->rules());

        //Recuperando os dados diretamenteo do fomrmulário
        $dataForm = $request->all();

        //Verificação ao enviar uma IMAGEM
        if ($request->hasFile($this->upload) && $request->file($this->upload)->isValid()) {
            //Recuperando a extenção do arquivo de origem upado
            $extension = $request->file($this->upload)->extension();

            //Gerando um nome único para o arquivo de imagem usando H=hora, i=minutos, s=segundos
            $nameGeradaAutomaticamente = uniqid(date('His'));

            //Atribuindo o nome e extenção propriamente dito à variável "$nameFile"
            $nameFile = "{$nameGeradaAutomaticamente}.{$extension}";

            //177=height, 236=width, save()=diretório, 70=qualidade de 70%
            $upload = Image::make($dataForm[$this->upload])->resize($this->width, $this->height)->save(storage_path("app/public/{$this->path}/{$nameFile}", 70));

            //Caso dê tudo certo
            if (!$upload) {
                //Mensagem de erro, 500=mensagem padrão de erro no JSON
                return response()->json(['error' => 'Falha ao fazer upload da imagem'], 500);
            } else {
                //Aqui será enviada a imagem para o banco de localmente
                $dataForm[$this->upload] = $nameFile;
            }
        }

        //Inserindo os dados propriamente dito
        $data = $this->model->create($dataForm);
        return response()->json($data, 201);
    }

    //Método SELECT ID
    public function show($id)
    {
        //Ir até o nosso objeto/classe CLiente resgatar o ID passado como parâmetro
        if (!$data = $this->model->find($id)) {
            //Mensagem de erro, 404=mensagem padrão de "NOT FOUND" no JSON
            return response()->json(['error' => 'Registro não encontrado'], 404);
        } else {
            //Selecionando os dados propriamente dito
            return response()->json($data);
        }
    }


    //Método UPDATE
    public function update(Request $request, $id)
    {
        //Ir até o nosso objeto/classe CLiente resgatar o ID passado como parâmetro
        if (!$data = $this->model->find($id))
            //Mensagem de erro, 404=mensagem padrão de "NOT FOUND" no JSON
            return response()->json(['error' => 'Registro não encontrado'], 404);

        //Aplicando regras de validação
        $this->validate($request, $this->model->rules());

        //Recuperando os dados diretamenteo do fomrmulário
        $dataForm = $request->all();

        //Verificação ao enviar uma IMAGEM
        if ($request->hasFile($this->upload) && $request->file($this->upload)->isValid()) {

            //Variável responsável por receber o atributo "image"
            $arquivoUpload = $this->model->arquivoImageUpload($id);

            //Verifica se o arquivo existe
            if ($arquivoUpload) {
                Storage::disk('public')->delete("/{$this->path}/$arquivoUpload");
            }

            //Recuperando a extenção do arquivo de origem upado
            $extension = $request->file($this->upload)->extension();

            //Gerando um nome único para o arquivo de imagem usando H=hora, i=minutos, s=segundos
            $nameGeradaAutomaticamente = uniqid(date('His'));

            //Atribuindo o nome e extenção propriamente dito à variável "$nameFile"
            $nameFile = "{$nameGeradaAutomaticamente}.{$extension}";

            //177=height
            //236=width
            //save()=diretório
            //70=qualidade de 70%
            $upload = Image::make($dataForm[$this->upload])->resize($this->width, $this->height)->save(storage_path("app/public/{$this->path}/{$nameFile}", 70));

            //Caso dê tudo certo
            if (!$upload) {
                //Mensagem de erro, 500=mensagem padrão de erro no JSON
                return response()->json(['error' => 'Falha ao fazer upload da imagem'], 500);
            } else {
                //Aqui será enviada a imagem para o banco de localmente
                $dataForm[$this->upload] = $nameFile;
            }
        }

        //Atualizando os dados propriamente dito
        $data->update($dataForm);
        return response()->json($data);
    }

    //Método DELETE
    public function destroy($id)
    {
        //Ir até o nosso objeto/classe CLiente resgatar o ID passado como parâmetro
        if ($data = $this->model->find($id)){
            //Verifica se exise um arquivo de imagem válido no formulário
            if (method_exists($this->model, 'arquivoImageUpload')) {
                Storage::disk('public')->delete("/{$this->path}/{$this->model->arquivoImageUpload($id)}");
            }

            //Deletando os dados propriamente dito
            $data->delete();
            return response()->json(['success' => 'Registro deletado com suesso!']);
        }else{
            //Mensagem de erro, 404=mensagem padrão de "NOT FOUND" no JSON
            return response()->json(['error' => 'Registro não encontrado'], 404);
        }        
    }

}
