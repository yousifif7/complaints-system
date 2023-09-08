@extends('layouts.mainView')
@section('title')
الطلبات
@endsection
@section('op')طلبات المواطنين @endsection
@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    <style>
        .content{
            padding: 5px;
            width: 100%;
            height: 120px;
            overflow: auto;
        }
        th{
            color: black;
        }
        .div{
            overflow:auto;
        }
        
    </style>
@endsection

@section('content')
@section('active1') text-danger disabled @endsection

<div class="div p-3">
<table id="datatable" class="table table-bordered">
    <thead class="bg-light tablehead" >
        <tr>
            <th scope="col">#</th>
            <th scope="col">القسم </th>
            <th scope="col">الفئة </th>
            <th scope="col">الاسم</th>
            <th scope="col">العنوان</th>
            <th scope="col">ملفات مرفقة</th>
            <th scope="col">تاريخ التقديم</th>
            <th scope="col">العمليات</th>
            <th scope="col">الحالة</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($myrequest as $myrequest )
        <?php 
        $cat= App\Models\Category::find($myrequest->category_id);
        $req= App\Models\RequestType::find($myrequest->requesttype_id);?>
            <tr>
                <td>{{$cat->id."0".$req->id."0".$myrequest->id}}</td>
                <td>{{$cat->catName }}</td>
                <td>{{$req->request_name}}</td>
                <td>{{$myrequest->name}}</td>
                <td>{{$myrequest->address}}</td>
                <td>
                    @if ($myrequest->file !== '')    
                        <a target="_blank" href="{{asset('userFiles/'.$myrequest->file)}}">
                            <img src="{{asset('userFiles/'.$myrequest->file)}}" style="height: 100px; ">
                        </a>                       
                    @endif
                </td>
                <td>{{$myrequest->created_at}}</td>
                <td> 
                    {{-- قائمة عرض تفاصيل الطلب --}}
                    <a class="btn btn-secondary m-1" target="_blank" href="{{route('form.show',$myrequest->id)}}">عرض</a>
                    <form action="{{route('form.destroy',$myrequest->id)}}" method="post">
                        @method('DELETE') @csrf
                        <button class="btn btn-danger m-1" >حذف</button>
                    </form> <br>   

                </td>
                <td @if ($myrequest->status=="1") class="text-danger" @endif 
                    @if ($myrequest->status=="2") class="text-success" @endif
                    @if ($myrequest->status=="3") class="text-warning" @endif>

                    @if ($myrequest->status=="1")
                    <h5>نشطة </h5>
                    @elseif ($myrequest->status=="2")
                    <h5>مكتملة </h5>
                    @elseif ($myrequest->status=="3")
                    <h5>عالقة </h5>
                    @endif
                    <form action="{{route('form.edit',$myrequest->id)}}" method="get">
                        @csrf
                        @if ($myrequest->status=='2')   
                        
                        @else
                        <select class="form-select" name="status" >
                            <option value="1" >نشطة</option>
                            <option value="2" >مكتملة</option>
                            <option value="3" >عالقة</option>
                        </select>
                        <button class="btn btn-outline-success btn-sm text-center" >تأكيد</button>
                        @endif
                    </form>
            </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
    <div class="container text-center">
        {{-- <a class="btn btn-danger " href="{{route('forms.delete')}}" >حذف كل الطلبات</a>
        <a class="btn btn-danger " href="{{route('forms.deletecomp')}}" > حذف الطلبات المكتملة</a> --}}
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