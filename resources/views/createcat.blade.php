@extends('layouts.mainView')
@section('title')
إضافة فئة
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    <style>
        .dataTables_wrapper {
            margin:10px;
        }
        .dataTable{
            overflow: scroll;
        }
    </style>
@endsection

@section('content')
@section('op') إضافة قسم @endsection
@section('active2') text-danger disabled @endsection

<div class="container text-right">
    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">أضف قسم</button>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
      <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">أضف قسم جديد</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">

          <form class="form" method="get" action="{{route('category.storeCat')}}" >
              @csrf
              <h3 class="text-center text-success">أضف قسم جديد</h3>
              <div class="form-group m-1">
                <label for="exampleInputEmail1">اسم القسم</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="createdCatName">
                  @error('name')
                   <div class="alert alert-danger">يرجى إدخال الاسم</div>
                  @enderror
              </div><br>
              <button class="button btn-center w-100" name="submit" type="submit" style="float: center;">تأكيد </button>
            </form>
        </div>
    </div>

<hr>
<h3 class="text-center text-success">الفئات المضافة مسبقاً</h3>
<table id="datatable" class="table container table-bordered">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">اسم القسم</th>
        <th scope="col">التعديل</th>
        <th scope="col">الحذف</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($category as $category )

        <?php 
        // $cat= App\Models\Category::find($myrequest->category_id);
        // $req= App\Models\RequestType::find($myrequest->requesttype_id);?>
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->catName}}</td>
                <td>
                    <a class="btn btn-secondary" href="{{route('category.edit',$category->id)}}">تعديل</a>
                </td>
                <td>    
                    <form action="{{route('category.destroy',$category->id)}}" method="post">
                        @method('DELETE') @csrf
                        <button class="btn btn-danger" >حذف</button>
                    </form>
                </td>
            </tr>
            
        @endforeach
    </tbody>
  </table>
</div>  
@endsection

@section('scripts')
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#datatable').DataTable();
        });
    </script>
@endsection