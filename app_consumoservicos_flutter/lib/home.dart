import 'package:flutter/material.dart';
import 'package:flutter_consumo_servicos_ava_1/post.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'dart:async';

class Home extends StatefulWidget {
  @override
  _HomeState createState() => _HomeState();
}

class _HomeState extends State<Home> {

  /*
  ERROR
  Configurando o emulador => SETTINGS -> USE ANDROID STUDIO HTTP PROXY SETTINGS -> NO PROXY
  Configurando o emulador => SETTINGS -> MANUAL PROXY CONFIGURATION ->PROXY -> HOST_NAME=192.168.15.11 -> PORT=80
  */
  /*
  String _urlBase = "https://jsonplaceholder.typicode.com";
  String _urlBase = "http://localhost/<endpoint>";
  String _urlBase = "http://localhost:80/api_consumoservicos_laravel.test/api";
  String _urlBase = "http://api_consumoservicos_laravel.test/api";
  String _urlBase = "http://localhost/api_consumoservicos_laravel/public/api";
  String _urlBase = "http://localhost:80/api_consumoservicos_laravel/public/api";
  String _urlBase = "http://192.168.15.11:80/api_consumoservicos_laravel.test/api";
  */

  /*
  SUCCESS
  Configurando o emulador => SETTINGS -> USE ANDROID STUDIO HTTP PROXY SETTINGS -> NO PROXY
  Configurando o emulador => SETTINGS -> MANUAL PROXY CONFIGURATION ->PROXY -> HOST_NAME=192.168.15.11 -> PORT=80
  */
  String _urlBase = "http://192.168.15.11:80/api_consumoservicos_laravel/public/api";

  Future<List<Post>> _recuperarPostagens() async {
    
    http.Response response = await http.get( _urlBase + "/posts" );
    var dadosJson = json.decode( response.body );

    List<Post> postagens = List();
    for( var post in dadosJson ){
      
      print("post: " + post["title"] );
      Post p = Post(post["id"], post["userId"], post["title"], post["body"]);
      postagens.add( p );
    
    }
    return postagens;
    //print( postagens.toString() );
    
  }

  _post() async {

    //http.Response response = await http.get( _urlBase + "/posts" );

    //Post post = new Post(1, null, "Titulo Post", "Corpo da postagem Post");
    Post post = new Post(null, 1, "Titulo Post", "Corpo da postagem Post");

    var corpo = json.encode(
        post.toJson()
    );

    http.Response response = await http.post(
        _urlBase + "/posts",
      headers: {
        "Content-type": "application/json; charset=UTF-8"
      },
      body: corpo
    );

    print("resposta: ${response.statusCode}");
    print("resposta: ${response.body}");
    print("resposta: Cadastrado com sucesso");

  }

  _put() async {

    //Post post = new Post(120, null, "Titulo Put", "Corpo da postagem Put");
    Post post = new Post(8, 1, "Titulo Put", "Corpo da postagem Put");

    var corpo = json.encode(
        post.toJson()
    );

    http.Response response = await http.put(
        _urlBase + "/posts/8",
        headers: {
          "Content-type": "application/json; charset=UTF-8"
        },
        body: corpo
    );

    print("resposta: ${response.statusCode}");
    print("resposta: ${response.body}");
    print("resposta: Atualizado com sucesso");

  }

  _patch() async {

    //Post post = new Post(120, null, "Titulo Patch", "Corpo da postagem Patch");
    Post post = new Post(8, 1, "Titulo Patch", "Corpo da postagem Patch");

    var corpo = json.encode(
        post.toJson()
    );

    http.Response response = await http.patch(
        _urlBase + "/posts/8",
        headers: {
          "Content-type": "application/json; charset=UTF-8"
        },
        body: corpo
    );

    print("resposta: ${response.statusCode}");
    print("resposta: ${response.body}");
    print("resposta: Atualizado com sucesso");

  }

  _delete() async {

    http.Response response = await http.delete(
      _urlBase + "/posts/8"
    );

    print("resposta: ${response.statusCode}");
    print("resposta: ${response.body}");
    print("resposta: Removido com sucesso");

  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Consumo de serviço avançado"),
      ),
      body: Container(
        padding: EdgeInsets.all(16),
        child: Column(
          children: <Widget>[
            Row(
              children: <Widget>[
                RaisedButton(
                  child: Text("Salvar"),
                  onPressed: _post,
                ),
                RaisedButton(
                  child: Text("Atualizar"),
                  onPressed: _put,
                ),
                RaisedButton(
                  child: Text("Remover"),
                  onPressed: _delete,
                ),
              ],
            ),
            Expanded(
              child: FutureBuilder<List<Post>>(
                future: _recuperarPostagens(),
                builder: (context, snapshot){

                  switch( snapshot.connectionState ){
                    case ConnectionState.none :
                    case ConnectionState.waiting :
                      return Center(
                        child: CircularProgressIndicator(),
                      );
                      break;
                    case ConnectionState.active :
                    case ConnectionState.done :
                      if( snapshot.hasError ){
                        print("lista: Erro ao carregar ");
                      }else {
                        return ListView.builder(
                            itemCount: snapshot.data.length,
                            itemBuilder: (context, index){

                              List<Post> lista = snapshot.data;
                              Post post = lista[index];

                              return ListTile(
                                title: Text( post.title ),
                                subtitle: Text( post.id.toString() ),
                              );

                            }
                        );

                      }
                      break;
                  }

                },
              ),
            )



          ],
        ),
      ),
    );
  }
}
