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
            <a class="navbar-brand" href="../public/Main">Day Schedule</a>
        </div>
        <ul class="nav navbar-nav">

        </ul>
        <ul class="nav navbar-nav navbar-right">

            <li class="{{Request::is('/logout')?'active':null}}"><a href="{{url('/logout')}}"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>        </ul>
    </div>
</nav>

<body>


<?php
$dbc = mysqli_connect('localhost', 'root', '', 'schedule');
if (!$dbc) {
    die ("Can't connect to MySQL:" . mysqli_error($dbc));
}

$today= date("Y-m-d");
$tomorrow=date('Y-m-d', strtotime($today. ' + 1 days'));
//$newformat = date('Y-m-d',$time);
$sqlfind ="select * from post where datetime_from > '$today' and datetime_from < '$tomorrow'";
//var_dump($nowdate);
$data = mysqli_query($dbc, $sqlfind);

?>

<table class="table table-hover" id="myTable">
    <thead>
    <tr class="header">
        <th>date from</th>
        <th>date to</th>
        <th>text</th>
        <th>category</th>
    </tr>

    </thead>
    <tbody>
    <?php
    while($row = mysqli_fetch_array($data)) {?>
    <tr>
        <td><?php echo $row['datetime_from'];   $idd =$row['id_Post'];?></td>
        <td><?php echo $row['datetime_to'];?></td>
        <td><?php echo $row['text'];?></td>
        <td><?php echo $row['category'];?></td>
        <td><?php echo" <a href=../public/Editpost?postid=",urlencode($idd),"><input type=button id='$idd' value='Edit' ></a> " ?></td>
    </tr>

    <?php }?>

    </tbody>
</table>




</body>




</html>