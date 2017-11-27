<?php

namespace App;

use App\Scope\WorkerScope;
use App\Transformers\WorkerTransformer;
use Illuminate\Database\Eloquent\Model;

class Worker extends User
{
    public $transformer = WorkerTransformer::class;

    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new WorkerScope);
    }
    public function area(){
        return $this->belongsTo('App\Department');
    }

    public function vacations(){
        return $this->hasMany(Vacation::class);
    }
}
