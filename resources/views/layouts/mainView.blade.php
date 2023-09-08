<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <!-- CSS only -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="shortcut icon" type="image/png" href="/files/general/file/favicon1441129132.png"/>
<link rel="shortcut icon" type="image/png" href="http://www.qarara.ps/files/general/file/favicon1441129132.png"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 
<link rel="stylesheet" href="/style.css"> 
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">

    
    <script src="https://kit.fontawesome.com/7ba6153525.js" crossorigin="anonymous"></script>
    @yield('styles')
    <style>
        *{
            font-family: 'Cairo', sans-serif;
        }
        .nav-link:hover{
            color: red;
        }
        </style>
    </head>
<body>
    
    <div class="navbar-header">
        <nav class="navbar navbar-light bg-dark">
            <a class="text-light" >@yield('op')</a>
            <a class="text-light " href="<?= url('/complaints'); ?>" ><b>الخدمات الإلكترونية</b></a>
            <a class="text-light"><img src="/bg.png" height="40px" class="d-inline-block align-top bg-dark" alt=""></a>    
        </nav> 
    <ul class="nav justify-content-center bg-light">
        <li class="nav-item">
          <a class="nav-link @yield('active1') " href="<?= url('admins/forms');?>">الطلبات</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @yield('active2')" href="<?= url('admins/createcat');?>">الأقسام</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @yield('active3')" href="<?= url('admins/createreq_type');?>">فئات الطلبات</a>
        </li>
        <li class="nav-item">
          <a class="nav-link"></a>
        </li>
      </ul>
</div>      
<br>    
    @yield('content')
    

    <!-- JavaScript Bundle with Popper -->
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="/js/bootstrap.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/jquery-3.6.0.min.js"></script>
    @yield('scripts')

</body>
</html>