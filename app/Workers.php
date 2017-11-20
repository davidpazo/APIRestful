<?php

namespace App;

use App\Scope\WorkerScope;
use Illuminate\Database\Eloquent\Model;

class Workers extends User
{
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
