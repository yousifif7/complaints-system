@extends('layouts.nav_footer')

@section('styles')
  <style>
    footer {
      
    }
  </style>
@endsection
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> تقديم طلب | {{$cat->catName}}</title>
</head>
<body>
    <body>
      {{-- Cat is for category --}}
      
        @section('content')
        @section('op') {{$cat->catName}} @endsection

        <br><hr>
        <h2 style="text-align:center;"> {{$cat->catName}}</h2>
        <hr>
        <div class="row justify-content-center " style="margin:auto;">
          <div class="col-md-8 order-md-1">
    
            <form class="form" action="{{route('form.store')}}" method="post" enctype="multipart/form-data">
              @csrf

              @if (count($errors) > 0)
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
            @endif

              <div class="form-group" >
                <input type="hidden" class="form-control" name="category" value="{{$cat->id}}">
              </div>
              <div class="form-group" >
                <input type="hidden" class="form-control" name="status" value="1">
              </div>
              <div class="form-group" >
                <label for="exampleFormControlInput1">اسم المواطن</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="ادخل اسمك رباعياً">
                    @error('name')
                      <div class="alert alert-danger">يرجى إدخال الاسم</div>
                    @enderror
              </div>
              <br>
              <div class="form-group" >
                <label for="exampleFormControlInput1">رقم الهاتف المحمول</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="ادخل رقم هاتفك" >
                <small class="form-text text-success">فقط رقم الهاتف المحمول 
                  (جوال / وطنية)</small><br>
                  @error('phone')
                    <div class="alert alert-danger">يرجى إدخال رقم الهاتف بشكلٍ صحيح</div>
                  @enderror
              </div>
              <div class="form-group">
                <label for="exampleFormControlInput1">العنوان</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="ادخل محل إقامتك">
                  @error('address')
                    <div class="alert alert-danger">يرجى إدخال العنوان</div>
                  @enderror
              </div>
              <br>
              <div class="form-group">
                <label for="exampleFormControlSelect1">اختر فئة الطلب</label>
                <select class="form-control " name="formtype">
                  <option></option>
                  @foreach ($reqtype as $reqtype )
                   @if ($cat->id === $reqtype->category_id)
                     <option value="{{$reqtype->id}}">{{$reqtype->request_name}}</option>
                     @endif
                  @endforeach
                </select>
              </div>
              <br>
              <div class="form-group">
                <label for="exampleFormControlTextarea1">موضوع الطلب</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="content"></textarea>
              </div>
              <br>
              <label for="exampleFormControlSelect1">ارفق ملفًا أو صورة</label>
              <div class="input-group mb-3 file">
                <input type="file" class="form-control fileup" name="userfile" multiple><br><br>
              </div><br>           
            <button class="button btn-center w-100" name="submit" type="submit" style="float: center;">تأكيد الطلب</button><br><br>
            {{-- <button class="btn btn-outline-primary btn-center w-100" name="submit" style="float: center;">تأكيد الطلب</button> --}}
          </form>
          </div>
        </div>
       
        <br><br>
        
        @endsection
    </body>
</body>
</html>
