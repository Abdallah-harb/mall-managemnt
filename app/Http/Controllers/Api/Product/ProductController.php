<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Helper\HelperFile;
use App\Http\Helper\ResponseHelper;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $products =Product::with('categories')->get();
            if(isset($products) & count($products) < 1){
                return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,"No Product Exists");
            }
            return  ResponseHelper::sendResponseSuccess(ProductResource::collection($products));

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
            $product_img = '';
            if($request->hasFile('photo')){
                $product_img = HelperFile::uploadImage($request->photo,'products');
            }
            $product =Product::create([
                "vendor_id" =>$request->vendor_id,
                "name" => $request->name,
                "description"=>$request->description,
                "price"=>$request->price,
                "manufacture_company"=>$request->manufacture_company,
                "photo"=>$product_img
            ]);
            $product->categories()->attach($request->category_id);
            return  ResponseHelper::sendResponseSuccess(new ProductResource($product));

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
            $product =Product::find($id);
            if(!$product){
                return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,"This Product id not Exists");
            }
            return  ResponseHelper::sendResponseSuccess(new ProductResource($product));

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
            $product =Product::find($id);
            if(!$product){
                return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,"This Product id not Exists");
            }
            $product_img = '';
            if($request->hasFile('photo')){
                $product_img = HelperFile::uploadImage($request->photo,'products');
                $product->update(['photo'=>$product_img]);
            }
            $product->update($request->except(['id','photo']));
            $product->categories()->sync($request->category_id);
            return  ResponseHelper::sendResponseSuccess(new ProductResource($product));

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
            $product =Product::find($id);
            if(!$product){
                return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,"This Product id not Exists");
            }
            $product->delete();
            $product->categories()->detach();
            return  ResponseHelper::sendResponseSuccess([],Response::HTTP_OK,'Product Deleted');

        }catch (\Exception $ex){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$ex->getMessage());
        }
    }
}
