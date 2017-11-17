<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workers extends User
{
    public function area(){
        return $this->belongsTo('App\Department');
    }

    public function vacations(){
        return $this->hasMany(Vacation::class);
    }
}
