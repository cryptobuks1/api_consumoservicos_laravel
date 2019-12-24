<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateController extends Controller
{
    //Método que torna obrigatório o token para todas as rotas configuradas no nosso arquivo "routes/api.php"
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['authenticate']]);
    }

    //Método de autenticação via TOKEN provido pelo nosso JWT - JSON WEB TOKEN
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        //Recuperando o usuário que está tentando fazer o login
        $user = auth()->user();

        // all good so return the token and user loged
        return response()->json(compact('token', 'user'));
    }

    // somewhere in your controller
    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

    //Método para dar um refresh no token existente, permitindo ao usuário gerar um novo token
    public function refreshToken()
    {
        if(!$token = JWTAuth::getToken())
            return response()->json(['error', 'token_not_send'], 401);

        try{
            $token = JWTAuth::refresh();
            
        }catch(Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
            return response()->json(['token_invalid'], $e->getStatusCode());
        }

        return response()->json(compact('token'));
     }
         
    //Método para deslogar o usuário do sistema
    public function logout()
    {
        //Recuperando o usuário que está tentando fazer o login
        $user = auth()->user();

        if($user){
            auth()->logout();
            return response()->json(['message' => 'Usuário deslogado com sucesso!']);

        }else{
            return response()->json(['message' => 'Não foi possível deslogar!']);
        }
        

        
    }



}
