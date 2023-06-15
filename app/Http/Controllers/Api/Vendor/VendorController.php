<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Helper\HelperFile;
use App\Http\Helper\ResponseHelper;
use App\Http\Requests\Vendor\VendorRequest;
use App\Http\Resources\VendorResource;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $vendor = Vendor::with(['department'])->get();
            if(!$vendor){
                return  ResponseHelper::sendResponseSuccess([],Response::HTTP_OK,'no Vendor Yet');
            }
            return  ResponseHelper::sendResponseSuccess(VendorResource::collection($vendor));

        }catch (\Exception $ex){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$ex->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VendorRequest $request)
    {
        try {
            $vendor_logo = '';
            if($request->hasFile('logo')){
                $vendor_logo = HelperFile::uploadImage($request->logo,'vendors');
            }
            $vendor = Vendor::create([
               'department_id' => $request->department_id,
               'name'    => $request->name,
               'phone' => $request->phone,
               'description' => $request->description,
               'logo' => $vendor_logo
            ]);
            return  ResponseHelper::sendResponseSuccess(new VendorResource($vendor));

        }catch (\Exception $ex){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {

            $vendor = Vendor::find($id);
            if(!$vendor){
                return  ResponseHelper::sendResponseSuccess([],Response::HTTP_OK,'This vendor doesnot Exist');
            }
            return  ResponseHelper::sendResponseSuccess(new VendorResource($vendor));

        }catch (\Exception $ex){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$ex->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VendorRequest $request, string $id)
    {
        try {

            $vendor = Vendor::find($id);
            if(!$vendor){
                return  ResponseHelper::sendResponseSuccess([],Response::HTTP_OK,'This vendor doesnot Exist');
            }
            $vendor_logo = '';
            if($request->hasFile('logo')){
                $vendor_logo = HelperFile::uploadImage($request->logo,'vendors');
            }
            $vendor->update([
                'department_id' => $request->department_id,
                'name'    => $request->name,
                'phone' => $request->phone,
                'description' => $request->description,
                'logo' => $vendor_logo
            ]);
            return  ResponseHelper::sendResponseSuccess(new VendorResource($vendor));

        }catch (\Exception $ex){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $vendor = Vendor::find($id);
            if(!$vendor){
                return  ResponseHelper::sendResponseSuccess([],Response::HTTP_OK,'This vendor doesnot Exist');
            }
            $vendor->delete();
            return  ResponseHelper::sendResponseSuccess([],Response::HTTP_OK,'Vendor Deleted Successfully');

        }catch (\Exception $ex){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$ex->getMessage());
        }
    }
}
