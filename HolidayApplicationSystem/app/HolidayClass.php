<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class HolidayClass extends CommonClassMaster
{
    protected $table = 'common_class_master';

    protected static function boot(){
        parent::boot();
        self::addGlobalScope('holiday_class', function(Builder $builder){
            $builder->where('class_type_master_id', '1');
        });
    }
}
