<?php

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission
{

    protected $appends = ['title'];

    public function getTitleAttribute(){
        return __('permissions.'.$this->name);
    }

}
