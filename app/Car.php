<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
//    const CREATED_AT = 'create_time';
//    const UPDATED_AT = 'update_time';

    protected function getDateFormat(){
        return time();
    }


}
