<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>تفاصيل طلب</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/png" href="/files/general/file/favicon1441129132.png"/>
    <link rel="shortcut icon" type="image/png" href="http://www.qarara.ps/files/general/file/favicon1441129132.png"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="/style.css"> 
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">

    <style>
        *{
        font-family: 'Cairo', sans-serif;
            }
        h6,p{
            text-align: right;
        }
        .td-header{
            text-align: center;
        }
        img {
            max-width: 100%;
            height: auto;
        }
        table, th, td,tr {
            border: 3px solid black;
        }
    
    </style>

</head>
<body>
    <?php 
        $cat= App\Models\Category::find($myrequest->category_id);
        $req= App\Models\RequestType::find($myrequest->requesttype_id);?>

    <div style="" class="container">
    <div class="container">
        <img src="/header.jpg">
        <table class="table" style="">
            <thead>
                <tr class="tr">
                    <td class="td-header"><b>تاريخ الطلب : {{date_format($myrequest->created_at,'d:m:Y')}}</b></td>
                    <td class="td-header"><b>فئة الطلب : {{$req->request_name}}</b>
                    </td>
                    <td class="td-header"><b>رقم الطلب : {{$cat->id."0".$req->id."0".$myrequest->id}}</b>
                    </td>
                </tr>
            </thead>
        </table>
        
        <table class="table" >
            <tbody>
            <tr>
                <td><b>حالة الطلب: </b>
                    @if ($myrequest->status=="1")نشطة 
                    @elseif ($myrequest->status=="2")مكتملة 
                    @elseif ($myrequest->status=="3")عالقة 
                    @endif</td>
                    <td><b>نوع الطلب: </b>{{$req->request_name}}</td>
                    <td><b>القسم المختص  : </b>{{$cat->catName }}</td>
            </tr>
            <tr>
                <td colspan="2"><b>رقم الهاتف : </b>{{$myrequest->phone}}</td>
                <td colspan="1"><b>الاسم: </b>{{$myrequest->name}}</td>
            </tr>
            <tr>
                <td colspan="3"><b>تفاصيل الطلب : </b> {{$myrequest->content}}</td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="" style="text-align: right; ">
                        <p style="font-style:normal; font-weight:bold">مرفقات <br>
                            @if ($myrequest->file !== '')    
                            <a target="_blank" href="{{asset('userFiles/'.$myrequest->file)}}">
                                <img src="{{asset('userFiles/'.$myrequest->file)}}" style="height: 450px; ">
                            </a>
                        @else
                        <p style="color: red; font-style:oblique; font-weight:bold">ما من مرفقات لعرضها</p>                   
                        @endif
                        </a></p>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        


    </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="/js/bootstrap.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/jquery-3.6.0.min.js"></script>
</body>
</html>