<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helper\HelperFile;
use App\Http\Helper\ResponseHelper;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{

    public function register(RegisterRequest $request){

        $manager_photo = "";
        if($request->hasFile('photo')){
            $manager_photo = HelperFile::uploadImage($request->photo,'managers');
        }
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "password" => bcrypt($request->password),
            "address" => $request->address,
            "photo" =>$manager_photo,
            "type" => $request->type
        ]);
        $token = auth('api')->attempt(['email'=>$request->email,'password'=>$request->password]);
        $user->token = $token;
        return ResponseHelper::sendResponseSuccess(new AuthResource($user));
    }

    public function login(Request $request){
        if(!$token = auth('api')->attempt(['email'=> $request->email,"password"=>$request->password])){

            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,"Email Or Password Incorrect");
        }

        $user = User::whereEmail($request->email)->first();
        $user->token = $token;
        return ResponseHelper::sendResponseSuccess(new AuthResource($user));
    }



}
