<?php

namespace App\Repositories;
use App\Models\Department;
use App\Interfaces\DepartmentRepositoryInterface;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function index(){
        return Department::all();
    }

    public function getById($id){
       return Department::findOrFail($id);
    }

    public function store(array $data){
       return Department::create($data);
    }

    public function update(array $data,$id){
       return Department::whereId($id)->update($data);
    }
    
    public function delete($id){
       Department::destroy($id);
    }
}
