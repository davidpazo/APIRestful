<?php

namespace App;

use App\Transformers\DepartmentTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    public $transformer = DepartmentTransformer::class;
    //use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function workers()
    {
        return $this->hasMany('App\Worker');
    }
}
