@extends('layouts.mainView')
@section('title')
تعديل فئة
@endsection
@section('styles')
 
@endsection
@section('content')

@section('op') تعديل فئة @endsection
<form class="form" method="get" action="{{route('category.show',$category->id)}}">
    @method('PUT')
        @csrf
    <h3 class="text-center text-success">تعديل القسم </h3>
    <div class="form-group m-1">
        <label for="exampleInputEmail1">اسم القسم <strong>{{$category->catName}}</strong></label><br><br>
      <label for="exampleInputEmail1"> ادخل اسم القسم الجديد</label>
      <input type="text" class="form-control" name="createdCatName" value="{{$category->catName}}">
    </div><br>
    <button class="button btn-center w-100" name="submit" type="submit" style="float: center;">تأكيد </button>
  </form>

  @endsection