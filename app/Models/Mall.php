<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mall extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function department(){
        return $this->hasMany(Department::class,'mall_id');
    }
}
