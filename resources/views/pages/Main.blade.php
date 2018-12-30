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

</body>


</html>

<?php
// Set your timezone!!
date_default_timezone_set('Europe/Vilnius');
// Get prev & next month
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    // This month
    $ym = date('Y-m');
}
// Check format
$timestamp = strtotime($ym . '-01');  // the first day of the month
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}
// Today (Format:2018-08-8)
$today = date('Y-m-j');
// Title (Format:August, 2018)
$title = date('F, Y', $timestamp);
// Create prev & next month link
$prev = date('Y-m', strtotime('-1 month', $timestamp));
$next = date('Y-m', strtotime('+1 month', $timestamp));
// Number of days in the month
$day_count = date('t', $timestamp);
// 1:Mon 2:Tue 3: Wed ... 7:Sun
$str = date('N', $timestamp);
// Array for calendar
$weeks = [];
$week = '';
// Add empty cell(s)
$week .= str_repeat('<td></td>', $str - 1);
for ($day = 1; $day <= $day_count; $day++, $str++) {
    $date = $ym . '-' . $day;
    if ($today == $date) {
        $week .= '<td class="today">';
    } else {
        $week .= '<td id="click">';
    }
    $week .= $day . '</td>';
    // Sunday OR last day of the month
    if ($str % 7 == 0 || $day == $day_count) {
        // last day of the month
        if ($day == $day_count && $str % 7 != 0) {
            // Add empty cell(s)
            $week .= str_repeat('<td></td>', 7 - $str % 7);
        }
        $weeks[] = '<tr>' . $week . '</tr>';
        $week = '';
    }
}
?>
<script>

    click.onclick = function() {
        alert("Hello! I am an alert box!!");
    }
</script>

        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PHP Calendar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <style>
        .container {
            font-family: 'Montserrat', sans-serif;
            margin: 60px auto;
        }
        .list-inline {
            text-align: center;
            margin-bottom: 30px;
        }
        .title {
            font-weight: bold;
            font-size: 26px;
        }
        th {
            text-align: center;
        }
        td {
            height: 100px;
        }
        td:hover{
            background-color: #66ff33;
        }
        th:nth-of-type(6), td:nth-of-type(6) {
            color: blue;
        }
        th:nth-of-type(7), td:nth-of-type(7) {
            color: red;
        }
        .today {
            background-color: ghostwhite;
        }
    </style>
</head>
<body>
<div class="container">
    <ul class="list-inline">
        <li class="list-inline-item"><a href="?ym=<?= $prev; ?>" class="btn btn-link">&lt; prev</a></li>
        <li class="list-inline-item"><span class="title"><?= $title; ?></span></li>
        <li class="list-inline-item"><a href="?ym=<?= $next; ?>" class="btn btn-link">next &gt;</a></li>
        <li class="list-inline-item"><a href="../public/Day" class="btn btn-link">add action&gt;</a></li>

    </ul>
    <p class="text-right"><a href="../public/Today">Today</a></p>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>M</th>
            <th>T</th>
            <th>W</th>
            <th>T</th>
            <th>F</th>
            <th>S</th>
            <th>S</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($weeks as $week) {
            echo $week;
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>



