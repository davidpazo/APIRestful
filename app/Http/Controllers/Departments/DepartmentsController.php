<?php

namespace App\Http\Controllers\Departments;

use App\Department;
use App\Transformers\DepartmentTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class DepartmentsController extends ApiController
{
    /** constructor que llama al middleware para transformar los datos recibidos y que no haya conflictos de nombres */
    public function __construct()
    {
        $this -> middleware('auth:api')->only(['index','show']);
        $this -> middleware('client.credentials')->only(['index','show']);
        $this -> middleware('transform.input:'. DepartmentTransformer::class)->only(['store','update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Department $department)
    {
        $this->allowedAdminAction();
        $department = Department::all();
        return $this-> showAll($department);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name'=>'required',
        'description'=>'required',
        ];
        $this -> validate($request,$rules);
        $department = Department::create($request->all());
        return $this -> showOne($department,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        $this ->showOne($department);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        //Laravel 5.5-> cambiar intersect por only
        $department->fill($request->intersect([
            'name',
            'description',
        ]));
        if($department->isClean()){
            return $this ->errorResponse('Indique valores distintos para actualizar',422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department -> delete();
        return $this-> showOne($department);
    }
}
