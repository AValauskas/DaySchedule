<!DOCTYPE html>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/Calender.css') }}" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>


<nav class="navbar navbar-inverse" style="margin-bottom: 0px">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="../public/Main">Day Schedule</a>



            <ul class="nav navbar-nav">
                <li><a href="../public/editcustomerinfo">Edit personal info</a></li>
                <li><a href="../public/DiaryDisplay">Diary</a></li>
                <li class="list-inline-item"><a href="../public/DisplayValues" class="btn btn-link">Statistics</a></li>
            </ul>



        </div>
        <ul class="nav navbar-nav">

        </ul>
        <ul class="nav navbar-nav navbar-right">

            <li class="{{Request::is('/logout')?'active':null}}"><a href="{{url('/logout')}}"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>        </ul>
    </div>
</nav>

<body>

</body>


</html>