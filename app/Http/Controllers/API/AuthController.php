<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            "email" => 'required|email',
            "password" => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                "validation_error" => $validator->messages(),
            ]);
        }else{
            $user = User::where('email', $request->email)->first();

            if(!$user || ! Hash::check($request->password, $user->password)){
                return response()->json([
                    "status" => 401,
                    "message" => "Invalid Credentials"
                ]);
            }else{

                $token = $user->createToken($user->email.'_token')->plainTextToken;
                return response()->json([
                    "status" => 200,
                    "username" => $user->name,
                    "token" => $token,
                    "message" => "Login Successfully",
                ]);
            }
        }
    }

    public function logout(){

        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json([
            "status" => 200,
            "message" => "Loged Out Successfully"
        ]);
    }
}
