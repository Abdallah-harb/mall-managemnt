<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\Controller;
use App\Http\Helper\HelperApp;
use App\Http\Helper\HelperFile;
use App\Http\Helper\ResponseHelper;
use App\Http\Requests\Manager\ManagerRequest;
use App\Http\Resources\ManagerResource;
use App\Models\Manager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class ManagerController extends Controller
{



    public function allManager(){
        try {

            $managers = User::with('malls')->whereType('manager')->orderBy('id','DESC')->get();

            if($managers){
                return ResponseHelper::sendResponseSuccess(ManagerResource::collection($managers));
            }
            return ResponseHelper::sendResponseSuccess([],Response::HTTP_OK,'No Managers Yet .!');

        }catch (\Exception $ex){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$ex->getMessage());
        }
    }

    public function edit(){
        try {
            $manager = User::whereId(auth('api')->user()->id)->first();

            if($manager){
                return ResponseHelper::sendResponseSuccess(new ManagerResource($manager));
            }
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,'This manager not exists .!');

        }catch (\Exception $ex){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$ex);
        }
    }

    public function update(Request $request){
       // try {
            $manager = User::whereId(auth('api')->user()->id)->first();
            if(!$manager){
                return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,'This manager not exists .!');

            }

            if($request->hasFile('photo')){
                $manager_photo = HelperFile::uploadImage($request->photo,'managers');
                $manager->update(['photo',$manager_photo]);
            }

            $manager->update($request->except('id','photo'));

            return ResponseHelper::sendResponseSuccess(new ManagerResource($manager));
/*
        }catch (\Exception $ex){

            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$ex);
        }*/
    }
    public function delete(){

        try {
            $manager = User::whereId(auth('api')->user()->id)->first();
            if(!$manager){
                return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,'This manager not exists .!');
            }
            $image_path     = base_path("\public\managers\\") .$manager->photo;
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            $manager->malls()->delete();
            $manager->delete();
            return ResponseHelper::sendResponseSuccess([],Response::HTTP_OK,'Manager Delete Successfully');
        }catch (\Exception $ex){

            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$ex->getMessage());
        }
    }


}
