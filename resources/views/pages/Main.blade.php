@include('pages.Menu')
<!DOCTYPE html>


<?php

if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
    $d = date_parse_from_format("Y-m", $ym);
    $month_num=$d["month"];
    $year=$d["year"];
    $timestamp = strtotime($ym . '-01');
    $prev = date('Y-m', strtotime('-1 month', $timestamp));
    $next = date('Y-m', strtotime('+1 month', $timestamp));
    //$transdate = date2('m-d-Y', time());
    $month = date("m");
    if (  $month==$month_num  )
        {
            $day_num=date("j");
        }
        else
            {
    $day_num=50;
    }
}
else
   {
$day_num=date("j"); //If today is September 29, $day_num=29
$month_num = date("m"); //If today is September 29, $month_num=9
$year = date("Y"); //4-digit year
$ym = date('Y-m');
$timestamp = strtotime($ym . '-01');
$prev = date('Y-m', strtotime('-1 month', $timestamp));
       $next = date('Y-m', strtotime('+1 month', $timestamp));
}
$date_today = getdate(mktime(0,0,0,$month_num,1,$year)); //Returns array of date info for 1st day of this month
$month_name = $date_today["month"]; //Example: "September" - to label the Calendar
$first_week_day = $date_today["wday"]-1; //"wday" is 0-6, 0 being Sunday. This is for day 1 of this month

$cont = true;
$today = 27; //The last day of the month must be >27, so start here
while (($today <= 32) && ($cont)) //At 32, we have to be rolling over to the next month
{
//Iterate through, incrementing $today
//Get the date information for the (hypothetical) date $month_num/$today/$year
    $date_today = getdate(mktime(0,0,0,$month_num,$today,$year));
//Once $date_today's month ($date_today["mon"]) rolls over to the next month, we've found the $lastday
    if ($date_today["mon"] != $month_num)
    {
        $lastday = $today - 1; //If we just rolled over to the next month, need to subtract 1 to get our $lastday
        $cont = false; //This kicks us out of the while loop
    }
    $today++;
}
?>
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
        height: 120px;
        width: 120px;
        text-align: right;
        vertical-align:top
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
    table{
        align:"center";
    }
    tr.border_bottom td {
        border-bottom:1pt solid black;
    }
</style>

<html lang="en">

<body>
<div class="container">
    <ul class="list-inline">
        <li class="list-inline-item"><a href="?ym=<?= $prev; ?>" class="btn btn-link">&lt; prev</a></li>
        <li class="list-inline-item"><span class="title"><?= "calender"; ?></span></li>
        <li class="list-inline-item"><a href="?ym=<?= $next; ?>" class="btn btn-link">next &gt;</a></li>
        <li class="list-inline-item"><a href="../public/Day" class="btn btn-link">add action&gt;</a></li>
        <li class="list-inline-item"><a href="../public/Diary" class="btn btn-link">Write Diary&gt;</a></li>
    </ul>
    <p class="text-right"><a href="../public/Today">Today</a></p>

</div>
<div class="container">
<?php
    echo "<table cellspacing=0 cellpadding=5 frame='all' rules='all' style='border:#808080 1px solid;'>
        <caption>$month_name $year</caption>
        <tr align=left><th>M</th><th>Tu</th><th>W</th><th>Th</th><th>F</th><th>Sa</th><th>Su</th></tr>";

    $day = 1; //This variable will track the day of the month
    $wday = $first_week_day; //This variable will track the day of the week (0-6, with Sunday being 0)
    $firstweek = true; //Initialize $firstweek variable so we can deal with it first
    while ( $day <= $lastday) //Iterate through all days of the month
    {
        if ($firstweek) //Special case - first week (remember we initialized $first_week_day above)
        {
            echo "<tr align=left>";
            for ($i=1; $i<=$first_week_day; $i++)
            {
                echo "<td> </td>"; //Put a blank cell for each day until you hit $first_week_day
            }
            $firstweek = false; //Great, we're done with the blank cells
        }
        if ($wday==0) //Start a new row every Sunday
            echo "<tr align=left>";

        //echo "<td onclick='tdclick(this);'";
       // echo "<td";
        $alld=mktime(0,0,0,$month_num,$day,$year);
        $alld2=mktime(23,59,59,$month_num,$day,$year);
        $dat=date("Y-m-d", $alld);
        $dattoprint=date("Y-m-d H:i:s", $alld);
        $dattoprint2=date("Y-m-d H:i:s", $alld2);
        ?>

         <td onclick='tdclick(<?php echo"$day";?>,<?php echo"$month_num";?>,<?php echo"$year";?>);'
        <?php


        if($day==$day_num) echo " bgcolor='yellow'"; //highlight TODAY in yellow?>
         >  <?php echo"$day";
             $dbc = mysqli_connect('localhost', 'root', '', 'schedule');
             if (!$dbc) {
                 die ("Can't connect to MySQL:" . mysqli_error($dbc));
             }
             $sql="select * from post where (datetime_from > '$dattoprint' and datetime_from < '$dattoprint2' ) or (datetime_to >'$dattoprint' and datetime_to <'$dattoprint2')";
             $data = mysqli_query($dbc, $sql);
             ?>
             <br>
             <table>

               <?php while($row = mysqli_fetch_array($data)) {?>
                   <tr class="border_bottom" align="left">
                 <?php $postdate=$row['datetime_from'];
                 $dateValue = strtotime($postdate);
                 $hour = date("H", $dateValue) ."";
                 $min = date("i", $dateValue)."";
                 $hours = strval($hour);
                 $mins = strval($min);
                 $both=$hours.':'.$min;
                 echo $both;
                 ?>

             </tr>
                   <br>
        <?php }

         ?>
             </table>
         </td>

        <?php
        if ($wday==6)
            echo "</tr>"; //If today is Saturday, close this row

        $wday++; //Increment $wday
        $wday = $wday % 7; //Make sure $wday stays between 0 and 6 (so when $wday++ == 7, this will take it back to 0)
        $day++; //Increment $day
    }

    while($wday <=6 ) //Until we get through Saturday
    {
        echo "<td> </td>"; //Output an empty cell
        $wday++;
    }
    echo "</tr></table>";
        ?>
</div>

<script>
    function tdclick(x,y,z){
        var d = new Date(z, y, x);
        month = '' + (d.getMonth()),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
        ats =[year, month, day].join('-');
        alert("td is clicked " +ats );
        window.location.href = "../public/Todaydisplay?ymd="+ats;
    };
</script>






</body>
</html>



