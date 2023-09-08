<?php

namespace App\Models;

use App\Models\Category;
use App\Models\RequestType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormType extends Model
{

    protected $fillable =['id','name','address','phone','content','file','status','category_id','requesttype_id',];

    public function Category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function RequestType(){
        return $this->belongsTo(RequestType::class,'requesttype_id');
    }
}
