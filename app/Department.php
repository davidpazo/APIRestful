<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function workers(){
        return $this->hasMany('App\Worker');
    }
}
