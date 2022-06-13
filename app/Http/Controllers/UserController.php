<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    public function register(UserRequest $request)
    {
        try {
            $user = User::create([
                'last_name' => $request['last_name'],
                'first_name' => $request['first_name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'role_id' => $request['role_id']
            ]);
        }
        catch(Exception $e){
            abort(422,'Problème lors de la validation');
        }

        return response()->json([
			'status' => 'Success',
			'message' => 'Utilisateur créé!',
			'data' => [
                'token' => $user->createToken('API Token')->plainTextToken
            ]
		], 201);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->toArray())) {
            abort(401,'Mauvais login et/ou mot de passe');
        }

        return response()->json([
			'status' => 'Succès',
			'message' => 'Connecté!',
			'data' => [
                'token' => Auth::user()->createToken('API Token')->plainTextToken
            ]
		], 200);
    }

    public function logout(Request $request)
    {
        // $request->user()->currentAccessToken()->delete();
                // Ligne précédente en commentaire puisqu'il crée une erreur. Je ne m'explique pas pourquoi, mais une fois dans cette fonction il n'y a plus de user
                // je ne suis donc pas capable d'avoir accès au token pour le supprimer/delete/revoke
        Auth::logout();
        return redirect('/');
    }

    public function show()
    {
        return Auth::user();
    }

    public function update(Request $request)
    {
        try{
            $user = User::find(Auth::id());
            $user->last_name = $request['last_name'];
            $user->first_name = $request['first_name'];
            $user->email = $request['email'];
            $user->role_id = $request['role_id'];

            $user->save();

            return response()->json([
                'status' => 'Succès',
                'message' => 'Utilisateur modifié!'
            ], 200);
        }
        catch(Exception $e){
            abort(422,'Problème lors de la validation');
        }
    } 

    public function updatePassword(Request $request)
    {
        try{
            $user = User::find(Auth::id());
            $user->password = bcrypt($request['password']);

            $user->save();

            return response()->json([
                'status' => 'Succès',
                'message' => 'Mot de passe modifié!'
            ], 200);
        }
        catch(Exception $e){
            abort(422,'Problème lors de la validation');
        }
    } 
}
