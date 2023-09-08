@extends('layouts/nav_footer')

@section('title')
بلدية القرارة | الخدمات الإلكترونية
@endsection

@section('styles')
  <style>
    footer {
      position: fixed;
      left: 0;
      bottom: 0;
      width: 100%;
    }
  </style>
@endsection

    @section('content')
    @section('op') الشكاوي والإقتراحات@endsection
    <div class="intro  w-100">
        <h5 class=" intro-text">من هنا يمكنك تقديم طلب أو شكوى تابعة لقسم محدد</h5>
    </div><br>

    @if (\Session::has('success'))
        <div class="alert alert-success text-center" role="alert" style="text-align: right;">
            تم تقديم الطلب بنجاح
            
            {{-- <button type="button" class="close" data-dismiss="alert">X</button> --}}
        </div>      
    @endif
    

    <div class="" >
        <div class="text">
            <h3 class="text-seconday ">إختيار  القسم المختص</h3> 
            <hr class="dropdown-divider">
            <div class="row justify-content-center m-1" >
                @foreach ($category as $category )
                <div class="col-12 col-lg-3 col-md-4 col-sm-12 m-1">
                    <div class="card " style="background-color:rgba(201, 201, 201, 0.486);" >
                        <div class="card-body">
                            <p class="">{{$category->catName}}</p>
                            <a class="btn" href="{{ route('category.cat', [$category->id]) }}" style="background-color: #b8ceca; ">تقديم طلب</a>
                        </div>
                    </div>
                </div>
                
                @endforeach
            </div>    
        </div>            
    </div>
    <br><br>
    @endsection
