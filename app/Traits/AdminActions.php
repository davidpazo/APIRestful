<?php

namespace App\Traits;

trait AdminActions
{

    public function before($user, $hability)
    {
        if ($user->esAdmin()) {
            return true;
        }
    }
}