@include('pages.Menu')
        <!DOCTYPE html>
<?php

$dbc = mysqli_connect('localhost', 'root', '', 'schedule');
if (!$dbc) {
    die ("Can't connect to MySQL:" . mysqli_error($dbc));
}

if(isset($_GET['from']))
{
    $from=$_GET['from'];
    $to=$_GET['to'];
    if (  $from>$to  )
        {
            $message="wrong date";

        }
    $result = $dbc->query("select value, COUNT(*) AS 'num' from rate where date >='$from' and date<='$to' group by value");
//    $sql="select * from diary where fk_Personid_Person='$uid' and date >='$from' and date<='$to' ";
}
else
{
    $from="";
    $to="";
    $result = $dbc->query("select value, COUNT(*) AS 'num' from rate group by value");
  //  $sql="select * from diary where fk_Personid_Person='$uid' ";
}



//$sql="select value, COUNT(*) AS 'num' from rate group by value";

//$data = mysqli_query($dbc, $sql);

/*while($row = mysqli_fetch_array($data)) {
    $value=$row['value'];
    var_dump($value);


}*/


//$row = mysqli_fetch_array($data) ->result_array();

//$value=$row['value'];
//var_dump($arr);
?>
<html>

<head>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

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
   <?php     }

?>


</body>
</html>
