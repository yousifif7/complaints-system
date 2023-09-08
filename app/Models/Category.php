<?php

namespace App\Models;


use App\Models\FormType;
use App\Models\RequestType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{

    protected $fillable=['id','catName'];

    public function FormType() {
        return $this->hasMany(FormType::class,'id');
    }
    public function RequestType() {
        return $this->hasMany(RequestType::class,'id');
    }
}
