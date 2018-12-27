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


<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Schedule</a>
        </div>
        <ul class="nav navbar-nav">

        </ul>
        <ul class="nav navbar-nav navbar-right">

            <li class="{{Request::is('/logout')?'active':null}}"><a href="{{url('/logout')}}"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>        </ul>
    </div>
</nav>

<body>

<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <form class="" action="{{URL::to('/addaction')}}" method="get">
            @csrf
            <h3>Add Action</h3><br>
            <div>
                <h2>Date from</h2> <input type="datetime-local" name="date_from" required>
                <h2>Date to</h2> <input type="datetime-local" name="date_to" required>
                <h2>Plan</h2> <input type="text" name="action" required/>
                <br><select name="kind">
                    <option value="1">science</option>
                    <option value="2">job</option>
                    <option value="3">sport</option>
                    <option value="4">freetime</option>
                </select >
            </div>
            <br>
            <?php
            if(isset($_SESSION['error']))
            {
                $wrong=$_SESSION['error'];
                echo "$wrong";
                $_SESSION['error']=null;
            }
            ?>
            <br>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <button type=submit name="button">Patvirtinti</button>

        </form>
    </div>
</div>
</body>


</html>