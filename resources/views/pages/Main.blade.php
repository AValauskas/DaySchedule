@include('pages.Menu')
<!DOCTYPE html>
<head>
    <link href="{{URL::asset('/css/MonthCalander.css')}}" rel="stylesheet" type="text/css" >
    <title>Schedule</title>
</head>

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
<html lang="en">
<style>
    div.postField{
        color: white;
        min-height: 100px;
        max-height:100px;
        overflow-y: auto;
    }
    div#post{
        background: #1d643b;
        margin-bottom: 5px;
        width: 100%;
    }
    div#postName{
        font-size: 100%;
        text-align: left;
        overflow: hidden;
        text-transform: full-width;
        white-space: nowrap;
    }
    div#postTime{
        font-size: 100%;
        text-align: right;
        overflow: hidden;
    }
</style>

<body>
<div class="calander">
    <div class="row" style="margin-right: 0px;margin-left: 0px;">
        <div class ="col-lg-3" style="padding-right: 0px;padding-left: 0px;">
            @include('pages.SideMenu')
        </div>

        <div class="col-lg-9" style="padding-right: 0px;padding-left: 0px;">

        <div class='row' id=date_info>
            <div class=col-lg-1>
              <a href="?ym=<?= $prev; ?>" class="btn btn-link arrow" style="color: black;font-size: 50px">&lt;</a>
            </div>
            <div class=col-lg-8>
                <?php echo "$month_name $year" ?>
            </div>
            <div class=col-lg-2 style="font-size: 100%;">
                <a href="../public/Day" style="color: black;font-size: 30px" class="btn btn-link">ADD POST</a>
            </div>
            <div class=col-lg-1>
               <a href="?ym=<?= $next; ?>" class="btn btn-link arrow" style="color: black;font-size: 50px"> &gt;</a>
            </div>
        </div>
        <div class='row' style='margin-right: 0px;margin-left: 0px;'>
        <table class='table-bordered' frame='all' rules='all'>
        <tr><th id="day">mon</th><th id="day">tue</th><th id="day">wed</th><th id="day">thu</th><th id="day">fri</th><th id="day">sat</th><th id="day">sun</th></tr>
<?php
    $day = 1; //This variable will track the day of the month
    $wday = $first_week_day; //This variable will track the day of the week (0-6, with Sunday being 0)
    $firstweek = true; //Initialize $firstweek variable so we can deal with it first
    while ( $day <= $lastday) //Iterate through all days of the month
    {
        if ($firstweek) //Special case - first week (remember we initialized $first_week_day above)
        {
            echo "<tr>";
            for ($i=1; $i<=$first_week_day; $i++)
            {
                echo "<td> </td>"; //Put a blank cell for each day until you hit $first_week_day
            }
            $firstweek = false; //Great, we're done with the blank cells
        }
        if ($wday==0) //Start a new row every Sunday
            echo "<tr>";

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
             //var_dump($sql);
             $data = mysqli_query($dbc, $sql);
             ?>
             <br>
                <div class="postField">
               <?php while($row = mysqli_fetch_array($data)) {?>
                 <?php $postdate=$row['datetime_from'];
                 $name = $row['text'];
                 $dateValue = strtotime($postdate);
                 $hour = date("H", $dateValue) ."";
                 $min = date("i", $dateValue)."";
                 $hours = strval($hour);
                 $mins = strval($min);
                 $both=$hours.':'.$min;
                 $id = $row['category'];

                 if ($id == 1){
                     $color = "#6f96d6";
                 } else if ($id == 2){
                     $color = "#b26e6e";
                 }else if  ($id == 3){
                     $color = "#789969";
                 } else {
                     $color = "#999169";
                 }
                 echo "<div class='row' style='background: $color' id='post'>
                            <div class='col-lg-7' id='postName'>$name</div>
                            <div class='col-lg-5' id='postTime'>$both</div>
                       </div>"
                 ?>
        <?php }

         ?>
                </div>
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
    </div>
</div>
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



