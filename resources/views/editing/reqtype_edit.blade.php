@extends('layouts.mainView')
@section('title')
تعديل فئة
@endsection
@section('styles')
  
@endsection
@section('op')  تعديل فئة طلب@endsection

@section('content')
<?php 
        $req= App\Models\RequestType::find($reqtype->category_id);
        $cat= App\Models\Category::find($reqtype->category_id);
        // $req= App\Models\RequestType::find($myrequest->requesttype_id);
        ?>

<form class="form" method="get" action="{{route('requesttype.update',$reqtype->id)}}" >
    @csrf
    @method('PUT')
      <h3 class="text-center text-success">تعديل فئة طلب جديد</h3>
      <div class="form-group m-1">
        <label for="exampleInputEmail1">نوع اطلب</label><br>
        <label for="exampleInputEmail1"><strong>{{$reqtype->request_name}}</strong></label><br>
        <input type="text" class="form-control" name="createdRequest" value="{{$reqtype->request_name}}">
      </div><br>
      <div class="form-group">
          <label for="exampleFormControlSelect1"> قسم الطلب</label><br>
          <label for="exampleInputEmail1"><strong>{{$cat->catName}}</strong></label><br>
        <select class="form-control" name="formCat">
          <option value="{{$cat->id}}" @checked(true) style="color: red;">{{$cat->catName}}</option>
          @foreach ($category as $category )
            @if ($cat->id !== $category->id)
             <option value="{{$category->id}}">{{$category->catName}}</option>
            @endif
          @endforeach 
          
        </select><br>
      </div>  
      <button class="button btn-center w-100" name="submit" type="submit" style="float: center;">تأكيد </button>
  
    </form>

  @endsection