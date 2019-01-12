@include('pages.Menu')
        <!DOCTYPE html>
<?php

$dbc = mysqli_connect('localhost', 'root', '', 'schedule');
if (!$dbc) {
    die ("Can't connect to MySQL:" . mysqli_error($dbc));
}
$percentarray = array();

if(isset($_GET['from']))
{
    $from=$_GET['from'];
    $fromtochange=$_GET['from'];
    $fromtoprint=$_GET['from'];
    $to=$_GET['to'];
    $toshow=$to;
    if (  $from>$to  )
        {
            $message="wrong date";

        }
    $result = $dbc->query("select value, COUNT(*) AS 'num' from rate where date >='$from' and date<='$to' group by value");
    while($fromtochange<=$to)
        {
            $date=date('Y-m-d', strtotime($fromtochange));
            $fromtochange=date('Y-m-d', strtotime($fromtochange. ' + 1 days'));


            $uid= $_SESSION['userid'];
            $minfail=0;
            $minsucces=0;
            $minwaiting=0;
            $total=0;
            $sqlfail="select * from post where fk_Personid_Person ='$uid' and datetime_from > '$date' and datetime_from < '$fromtochange' and status='4'";
            $sqlsucces="select * from post where fk_Personid_Person ='$uid' and datetime_from > '$date' and datetime_from < '$fromtochange' and status='2'";
            $sqlwaiting="select * from post where fk_Personid_Person ='$uid' and datetime_from > '$date' and datetime_from < '$fromtochange' and status='1'";
            $datafail = mysqli_query($dbc, $sqlfail);
            $datasucces = mysqli_query($dbc, $sqlsucces);
            $datawaiting = mysqli_query($dbc, $sqlwaiting);
            while($rowfail = mysqli_fetch_array($datafail))
            {
                $time1 = strtotime($rowfail['datetime_to']);
                $time2 = strtotime($rowfail['datetime_from']);
                $minfail=$minfail+$time1-$time2;


            }
            while($rowsucces = mysqli_fetch_array($datasucces))
            {
                $time1 = strtotime($rowsucces['datetime_to']);
                $time2 = strtotime($rowsucces['datetime_from']);
                $minsucces=$minsucces+$time1-$time2;
            }
            while($rowwaiting = mysqli_fetch_array($datawaiting))
            {
                $time1 = strtotime($rowwaiting['datetime_to']);
                $time2 = strtotime($rowwaiting['datetime_from']);
                $minwaiting=$minwaiting+$time1-$time2;

            }
            $total=$minfail+$minsucces+$rowwaiting;
            if ($total>0)
            {
                $percent=round($minsucces/$total*100);

            }else{$percent=0;}


            array_push($percentarray, $percent);
                    }

}
else
{
    $from="";
    $to="";
    $result = $dbc->query("select value, COUNT(*) AS 'num' from rate group by value");
    $date=date('Y-m-d');
    $toshow=$date;
    $timestamp = strtotime($date);
    $fromtochange = date('Y-m-d', strtotime('-1 month', $timestamp));
    $fromtoprint=$fromtochange;
        while($fromtochange<=$date)
        {
            $date2=date('Y-m-d', strtotime($fromtochange));
            $fromtochange=date('Y-m-d', strtotime($fromtochange. ' + 1 days'));
            $uid= $_SESSION['userid'];
            $minfail=0;
            $minsucces=0;
            $minwaiting=0;
            $total=0;
            $sqlfail="select * from post where fk_Personid_Person ='$uid' and datetime_from > '$date2' and datetime_from < '$fromtochange' and status='4'";
            $sqlsucces="select * from post where fk_Personid_Person ='$uid' and datetime_from > '$date2' and datetime_from < '$fromtochange' and status='2'";
            $sqlwaiting="select * from post where fk_Personid_Person ='$uid' and datetime_from > '$date2' and datetime_from < '$fromtochange' and status='1'";
            $datafail = mysqli_query($dbc, $sqlfail);
            $datasucces = mysqli_query($dbc, $sqlsucces);
            $datawaiting = mysqli_query($dbc, $sqlwaiting);
            while($rowfail = mysqli_fetch_array($datafail))
            {
                $time1 = strtotime($rowfail['datetime_to']);
                $time2 = strtotime($rowfail['datetime_from']);
                $minfail=$minfail+$time1-$time2;


            }
            while($rowsucces = mysqli_fetch_array($datasucces))
            {
                $time1 = strtotime($rowsucces['datetime_to']);
                $time2 = strtotime($rowsucces['datetime_from']);
                $minsucces=$minsucces+$time1-$time2;
            }
            while($rowwaiting = mysqli_fetch_array($datawaiting))
            {
                $time1 = strtotime($rowwaiting['datetime_to']);
                $time2 = strtotime($rowwaiting['datetime_from']);
                $minwaiting=$minwaiting+$time1-$time2;

            }
            $total=$minfail+$minsucces+$rowwaiting;
            if ($total>0)
            {
                $percent=round($minsucces/$total*100);

            }else{$percent=0;}


            array_push($percentarray, $percent);
        }

}




?>
<html>

<head>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(drawChart2);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],

                <?php foreach($result as $value){ ?>
                ['rate <?php echo "$value[value]";?> repeats:  <?php echo "$value[num]";?>',     <?php echo "$value[num]";?>],
               // document.write('<?php echo "$value[num]";?>');

                <?php } ?>

                ['15',    0]
            ]);

            var options = {
                title: 'Most popular day rates'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }

        function drawChart2() {


            var data = google.visualization.arrayToDataTable([
                ['day', 'rankings'],
                <?php   $k=0;
                    while($fromtoprint<=$toshow) {
                       // var_dump($fromtoprint);
                    $date = strtotime($fromtoprint);
                    $month = date('m', $date);
                    $day = date('d', $date);
                    ?>
                ['<?php echo "$month";?>-<?php echo "$day";?>',  <?php echo "$percentarray[$k]";?>],
                <?php


                        $k=$k+1;
                    $fromtoprint=date('Y-m-d', strtotime($fromtoprint. ' + 1 days'));

                    } ?>

            ]);
            var options = {
                title: 'Day efficiency',
                hAxis: {title: 'days',  titleTextStyle: {color: '#333'}},
                vAxis: {minValue: 0}
            };

            var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
            chart.draw(data, options);

        }

        $(document).ready(
            function() {
                $('#chart_div').call(drawChart2());
        });

    </script>
</head>
<body>
<div class="col-md-6 col-md-offset-3">
    <form class="" action="{{URL::to("/DisplayValues")}}" method="get">
        <input type="date" name="from" value="<?php echo $from; ?>"/><input type="date" name="to"  value="<?php echo $to; ?>" /><input name = "submit" type="submit" value="Rodyti">
    </form>
</div>
<br><br>


<?php
if(isset($message))
    {
        echo $message;
    }
    else
        {?>
<div id="piechart" style="width: 900px; height: 500px;"></div>
<div id="chart_div" style="width: 100%; height: 500px;"></div>
   <?php     }

?>


</body>
</html>
