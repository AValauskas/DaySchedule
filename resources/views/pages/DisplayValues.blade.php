@include('pages.Menu')
        <!DOCTYPE html>
<?php

$uid= $_SESSION['userid'];
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
    $result = $dbc->query("select value, COUNT(*) AS 'num' from rate where date >='$from' and date<='$to' and fk_Personid_Person='$uid' group by value");

   // $result2 = $dbc->query("select category, COUNT(*) AS 'num' from post where date >='$from' and date<='$to' group by category");
    $result2 = $dbc->query("select category, COUNT(*) AS 'num' from post where datetime_from >='$from' and datetime_from<='$to' and fk_Personid_Person='$uid' group by category");

    $result3 = $dbc->query("select * from post where datetime_from >='$from' and datetime_from<='$to' and fk_Personid_Person='$uid'");
    $minarray = array(0, 0, 0, 0,0);
    foreach($result3 as $value){
        $dfrom=$value['datetime_from'];
        $dto=$value['datetime_to'];
        $cate=$value['category'];
        $date = strtotime($dfrom);
        $date2 = strtotime($dto);
        $secs=$date2-$date;
        $mins=date('i', $secs);
        $hours=date('H', $secs);
        $total=$hours*60+$mins;
        $minarray[$cate]=$minarray[$cate]+$total;
    }


    while($fromtochange<=$to)
        {
            $date=date('Y-m-d', strtotime($fromtochange));
            $fromtochange=date('Y-m-d', strtotime($fromtochange. ' + 1 days'));
            $percent=Efficiencycalculate($date,$fromtochange);
            array_push($percentarray, $percent);
                    }

}
else
{
    $from="";
    $to="";
    $result = $dbc->query("select value, COUNT(*) AS 'num' from rate where fk_Personid_Person='$uid' group by value");
    $result2 = $dbc->query("select category, COUNT(*) AS 'num' from post where fk_Personid_Person='$uid' group by category");
    $result3 = $dbc->query("select * from post where fk_Personid_Person='$uid'");
    $minarray = array(0, 0, 0, 0,0);
    foreach($result3 as $value){
        $dfrom=$value['datetime_from'];
        $dto=$value['datetime_to'];
        $cate=$value['category'];
        $date = strtotime($dfrom);
        $date2 = strtotime($dto);
        $secs=$date2-$date;
        $mins=date('i', $secs);
        $hours=date('H', $secs);
        $total=$hours*60+$mins;

        $minarray[$cate]=$minarray[$cate]+$total;

    }

    $date=date('Y-m-d');
    $toshow=$date;
    $timestamp = strtotime($date);
    $fromtochange = date('Y-m-d', strtotime('-1 month', $timestamp));
    $fromtoprint=$fromtochange;


        while($fromtochange<=$date)
        {
            $date2=date('Y-m-d', strtotime($fromtochange));
            $fromtochange=date('Y-m-d', strtotime($fromtochange. ' + 1 days'));
            $percent=Efficiencycalculate($date2,$fromtochange);
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
        google.charts.setOnLoadCallback(drawChart3);
        google.charts.setOnLoadCallback(drawChart4);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],

                <?php foreach($result as $value){ ?>
                ['rate <?php echo "$value[value]";?> repeats:  <?php echo "$value[num]";?>',     <?php echo "$value[num]";?>],
               // document.write('<?php echo "$value[num]";?>');

                <?php } ?>
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

        function drawChart3() {
            alert="labas";
            var data = google.visualization.arrayToDataTable([
                ['category', 'Repeats'],
                    <?php foreach($result2 as $value){ ?>
                ['rate <?php
                        $val=$value['category'];
                        $sqlcat="select * from category where id_Category ='$val'";
                        $data2 = mysqli_query($dbc, $sqlcat);
                        $row = mysqli_fetch_array($data2);
                        echo "$row[name]";?> repeats:  <?php echo "$value[num]";?>',     <?php echo "$value[num]";?>],
                // document.write('<?php echo "$value[num]";?>');

                <?php } ?>
            ]);

            var options = {
                title: 'mostly engaged in activities',
                pieHole: 0.4,
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        }
        function drawChart4() {
            var data = google.visualization.arrayToDataTable([
                ["Element", "Density", { role: "style" } ],
                    <?php $sk=0;
                    foreach($minarray as $value){
                        if($sk==0){$sk=$sk+1;}else{?>
                    ["<?php
                        $val=$sk;
                        $sqlcat="select * from category where id_Category ='$val'";
                        $data2 = mysqli_query($dbc, $sqlcat);
                        $row = mysqli_fetch_array($data2);
                        echo "$row[name]";
                        ?>", <?php echo"$value"; ?>, "#b87333"],
                // document.write('<?php echo "$value[num]";?>');

                    <?php $sk=$sk+1;}} ?>

            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                { calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation" },
                2]);

            var options = {
                title: "mins spend on activities",
                width: 600,
                height: 400,
                bar: {groupWidth: "95%"},
                legend: { position: "none" },
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
            chart.draw(view, options);
        }



        $(document).ready(
            function() {
                $('#chart_div').call(drawChart2());
        });

        $(document).ready(
            function() {
                $('#donutchart').call(drawChart3());
            });
        $(document).ready(
            function() {
                $('#columnchart_values').call(drawChart4());
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
<div id="donutchart" style="width: 900px; height: 500px;"></div>
<div id="columnchart_values" style="width: 900px; height: 300px;"></div>
   <?php     }

?>


</body>
</html>
