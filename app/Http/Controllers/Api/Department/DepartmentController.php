<?php

namespace App\Http\Controllers\Api\Department;

use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseHelper;
use App\Http\Requests\Department\DepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $allDepartment = Department::with(['vendors','malls'=>function ($q){
                $q->select('id','name');
            }])->get();

            if(!$allDepartment){
                return ResponseHelper::sendResponseSuccess([],Response::HTTP_OK,'No Department yet');
            }
            return ResponseHelper::sendResponseSuccess(DepartmentResource::collection($allDepartment));
        }catch (\Exception $ex){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$ex->getMessage());
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {
        try {
            $check  =Department::whereName($request->name)->first();
            if($check){
                return ResponseHelper::sendResponseSuccess([],Response::HTTP_OK,"this Department is Created");
            }
            $department = Department::create($request->all());
            return ResponseHelper::sendResponseSuccess(new DepartmentResource($department));
        }catch (\Exception $ex){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $department = Department::find($id);
            if(!$department){
                return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,"This Department Not Exists ");
            }

            return ResponseHelper::sendResponseSuccess(new DepartmentResource($department));
        }catch (\Exception $ex){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$ex->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, string $id)
    {
        try {
            $department = Department::find($id);
            if(!$department){
                return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,"This Department Not Exists ");
            }
            $department->update($request->except('id'));

            return ResponseHelper::sendResponseSuccess(new DepartmentResource($department));
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
            $department = Department::find($id);
            if(!$department){
                return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,"This Department Not Exists ");
            }
            $department->delete();

            return ResponseHelper::sendResponseSuccess([],Response::HTTP_OK,'Department Delete Successfully');
        }catch (\Exception $ex){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$ex->getMessage());
        }
    }
}
