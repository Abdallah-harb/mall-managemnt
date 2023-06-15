<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Http\Helper\HelperFile;
use App\Http\Helper\ResponseHelper;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\VendorResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $categories = Category::get();
            if(count($categories) < 0){
                return  ResponseHelper::sendResponseSuccess([],Response::HTTP_OK,'no category Yet');
            }
            return  ResponseHelper::sendResponseSuccess(CategoryResource::collection($categories));

        }catch (\Exception $ex){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$ex->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $category = Category::create([
                'name'    => $request->name,
                'description' => $request->description
            ]);
            return  ResponseHelper::sendResponseSuccess(new CategoryResource($category));

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

            $category = Category::find($id);
            if(!$category){
                return  ResponseHelper::sendResponseSuccess([],Response::HTTP_OK,'This Category doesnot Exist');
            }
            return  ResponseHelper::sendResponseSuccess(new CategoryResource($category));

        }catch (\Exception $ex){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$ex->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $category = Category::find($id);
            if(!$category){
                return  ResponseHelper::sendResponseSuccess([],Response::HTTP_OK,'This Category doesnot Exist');
            }

            $category->update([
                'name'    => $request->name,
                'description' => $request->description
            ]);
            return  ResponseHelper::sendResponseSuccess(new CategoryResource($category));

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

            $category = Category::find($id);
            if(!$category){
                return  ResponseHelper::sendResponseSuccess([],Response::HTTP_OK,'This category doesnot Exist');
            }
            $category->delete();
            return  ResponseHelper::sendResponseSuccess([],Response::HTTP_OK,'Category Deleted Successfully');

        }catch (\Exception $ex){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$ex->getMessage());
        }
    }
}
