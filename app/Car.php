<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'cars';
    public $timestamps=false;
//    protected function getDateFormat(){
//        return time();
//    }
}