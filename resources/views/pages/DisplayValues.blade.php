@include('pages.Menu')
        <!DOCTYPE html>
<?php

$dbc = mysqli_connect('localhost', 'root', '', 'schedule');
if (!$dbc) {
    die ("Can't connect to MySQL:" . mysqli_error($dbc));
}
$sql="select value, COUNT(*) AS 'num' from rate group by value";
$sql2="select COUNT(*) AS 'num' from ";
$data = mysqli_query($dbc, $sql);

/*while($row = mysqli_fetch_array($data)) {
    $value=$row['value'];
    var_dump($value);


}*/
if ($result = $dbc->query("select value, COUNT(*) AS 'num' from rate group by value")) {
    printf("Select returned %d rows.\n", $result->num_rows);



}

//$row = mysqli_fetch_array($data) ->result_array();

//$value=$row['value'];
//var_dump($arr);
?>
<html>
<head>
    <?php  foreach ($result as $value) {
        echo "$value[num]";
        echo" ";
    }
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {






            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],

                <?php foreach($result as $value){ ?>
                ['<?php echo "$value[value]";?>',     <?php echo "$value[num]";?>],
               // document.write('<?php echo "$value[num]";?>');

                <?php } ?>

                ['15',    0]
            ]);

            var options = {
                title: 'My Daily Activities'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
</head>
<body>
<div id="piechart" style="width: 900px; height: 500px;"></div>
</body>
</html>
