<?php

namespace App\Http\Controllers\Api\Malls;

use App\Http\Controllers\Controller;
use App\Http\Helper\HelperFile;
use App\Http\Helper\ResponseHelper;
use App\Http\Resources\MallResource;
use App\Models\Mall;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MallController extends Controller
{
    public function index(){
        try {
            $malls = Mall::where('manager_id',auth('api')->user()->id)->get();

            if(!$malls){
                return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,'There Are No Malls yet');
            }


            return ResponseHelper::sendResponseSuccess(MallResource::collection($malls));

        }catch (\Exception $ex){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$ex->getMessage());

        }
    }


    public function create(Request $request)
    {
        try {
            $mall_photo = "";
            if($request->hasFile('photo')){
                $mall_photo = HelperFile::uploadImage($request->photo,'malls');
            }

            $manager = Mall::create([
                "manager_id" =>auth('api')->user()->id,
                "name" => $request->name,
                "address"=>$request->address,
                "phone" => $request->phone,
                "space" => $request->space,
                "note"=>$request->note,
                "photo" => $mall_photo

            ]);

            return ResponseHelper::sendResponseSuccess(new MallResource($manager));

        }catch (\Exception $ex){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$ex->getMessage());

        }
    }






    public function update(Request $request, $id)
    {
        try {
            $mall = Mall::find($id);
            if(!$mall){
                return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,'This Mall does not exist');
            }
            $mall_photo = "";
            if($request->hasFile('photo')){
                $mall_photo = HelperFile::uploadImage($request->photo,'malls');
            }
            $mall->update([
                "manager_id" =>auth('api')->user()->id,
                "name" => $request->name,
                "address"=>$request->address,
                "phone" => $request->phone,
                "space" => $request->space,
                "note"=>$request->note,
                "photo" => $mall_photo
            ]);
            return ResponseHelper::sendResponseSuccess(new MallResource($mall));
        }catch (\Exception $ex){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$ex->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $mall = Mall::find($id);
            if(!$mall){
                return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,'This Mall does not exist');
            }
            $mall->department()->delete();
            $mall->delete();
            return ResponseHelper::sendResponseSuccess([],Response::HTTP_OK,'Mall deleted Successfully');
        }catch (\Exception $ex){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$ex->getMessage());
        }
    }
}
