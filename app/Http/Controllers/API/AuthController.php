<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            "name" => 'required',
            "email" => 'required|email|max:191|unique:users,email',
            "password" => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                "validation_error" => $validator->messages(),
            ]);
        }else{
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
            ]);

            $token = $user->createToken($user->email.'_token')->plainTextToken;

            return response()->json([
                "status" => 200,
                "username" => $user->name,
                "token" => $token,
                "message" => "Registerd Successfully",
            ]);
        }
    }
}
