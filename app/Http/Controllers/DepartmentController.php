<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Interfaces\DepartmentRepositoryInterface;
use App\Classes\ApiResponseClass;
use App\Http\Resources\DepartmentResource;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    private DepartmentRepositoryInterface $DepartmentRepositoryInterface;
    
    public function __construct(DepartmentRepositoryInterface $departmentRepositoryInterface)
    {
        $this->departmentRepositoryInterface = $departmentRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->departmentRepositoryInterface->index();

        return ApiResponseClass::sendResponse(DepartmentResource::collection($data),'',200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        $details =[
            'name' => $request->name,
        ];
        DB::beginTransaction();
        try{
             $Department = $this->departmentRepositoryInterface->store($details);

             DB::commit();
             return ApiResponseClass::sendResponse('Department Create Successful','',201);

        }catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $Department = $this->departmentRepositoryInterface->getById($id);

        return ApiResponseClass::sendResponse(new DepartmentResource($Department),'',200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $Department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, $id)
    {
        $updateDetails =[
            'name' => $request->name,
        ];
        DB::beginTransaction();
        try{
             $Department = $this->departmentRepositoryInterface->update($updateDetails,$id);

             DB::commit();
             return ApiResponseClass::sendResponse('Department Update Successful','',201);

        }catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         $this->departmentRepositoryInterface->delete($id);

        return ApiResponseClass::sendResponse('Department Delete Successful','',204);
    }
}
