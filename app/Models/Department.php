<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function malls(){

        return $this->belongsTo(Mall::class,'mall_id','id');
    }
    public function vendors(){
        return $this->hasMany(Vendor::class);
    }

}
