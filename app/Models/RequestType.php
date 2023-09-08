<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestType extends Model
{
    protected $fillable = ['id','request_name','category_id'];

    Public function FormType(){
        return $this->hasMany(FormType::class,'id');
    }

    public function Category(){
        return $this->belongsTo(Category::class,'category_id');
    }
}
