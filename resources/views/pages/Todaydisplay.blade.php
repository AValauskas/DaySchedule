@include('pages.Menu')
        <!DOCTYPE html>
<style>

    #row1 {
        position: absolute;
        border-style: solid;
        width: 1100px;
        border-width: 1px;
        z-index: 10;

    }
    #row1:hover{
        background-color: yellow;
    }
    #row2 {
        position: absolute;
        border-width: 1px;
        z-index: 10;
    }




</style>
<html>

<body>



<?php
$date=$_GET['ymd'];
$dbc = mysqli_connect('localhost', 'root', '', 'schedule');
if (!$dbc) {
    die ("Can't connect to MySQL:" . mysqli_error($dbc));
}

$today= date("Y-m-d");
$tomorrow=date('Y-m-d', strtotime($date. ' + 1 days'));
$prev=date('Y-m-d', strtotime($date. ' - 1 days'));
//$newformat = date('Y-m-d',$time);
$sqlfind ="select * from post where datetime_from > '$date' and datetime_from < '$tomorrow' order by datetime_from";
var_dump($sqlfind);
$data = mysqli_query($dbc, $sqlfind);
$allfrom=0;
$allto=0;
$height=0;
$left=202;
$count=0;
?>

<ul class="list-inline">
    <li class="list-inline-item"><a href="?ymd=<?= $prev; ?>" class="btn btn-link">&lt; prev</a></li>
    <li class="list-inline-item"><span class="title"><?php echo "$date"; ?></span></li>
    <li class="list-inline-item"><a href="?ymd=<?= $tomorrow; ?>" class="btn btn-link">next &gt;</a></li>
    <li class="list-inline-item"><a href="?ymd=<?= $today; ?>" class="btn btn-link">today &gt;</a></li>
</ul>

<?php
$range = hoursRange();

?>

<div style=" position: relative ">
    <div  >

        <?php foreach( $range as $item){
        ?>

        <div class="row">
            <div class="col-sm-2"  style="background-color:#aaa; border-style: solid; border-width: 1px; height: 30px;  z-index: -1; ">
                <?php echo"$item"; ?>

            </div>

            <div class="col-sm-10" style="background-color:#bbb; border-style: solid; border-width: 1px; height: 30px;  z-index: -1; ">

            </div>

        </div>
        <?php
        }
        ?>
            <?php

            date_default_timezone_set('UTC');
            //$date = date('Y-m-d H:i:s');
            $hour=date("H");
            $sql="select * from rate where date='$date'";
            $data2 = mysqli_query($dbc, $sql);
            $row = mysqli_fetch_array($data2);
            $value =$row['value'];

            if(($hour>=20 && $date<=$today )|| $date<$today)
            {
            ?>
            <div class="container">
                <div class="col-md-6 col-md-offset-3">
                    <form class="" action="{{URL::to('/evaluate')}}" method="get">
                        @csrf
                        <h3>Your day evaluation!</h3><br>
                        <select  name="evaluation" required>
                            <option value="no"  disabled selected><?php echo"$value";?></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>

                        </select>

                        <input type="hidden" name="dat" value="{{$date}}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type=submit name="button">Patvirtinti</button>
                    </form>
                </div>
            </div>

            <?php
            }


            if( $date==$today ){
            ?>
            <li class="list-inline-item"><a href="../public/Diary" class="btn btn-link">Write Diary&gt;</a></li>
            <?php }

            if( $date>=$today ){
            ?>
            <td><?php echo" <a href=../public/Day?dt=",urlencode($date),"><input type=button id='$date' value='add action' ></a> " ?></td>

            <?php }?>




            <?php
            $sql2="select * from diary where date='$date'";
            $data3 = mysqli_query($dbc, $sql2);
            $row = mysqli_fetch_array($data3);
            if(isset($row))
            {
            ?>


            <div class="container">
                <div class="col-md-6 col-md-offset-3" >
                    <h2> <?php echo"$date "?> day diary</h2>
                    <?php

                    $toprint =$row['text'];
                    echo " $toprint";?>
                </div>
            </div>
            <?php
            }?>


        <center><h2>Day Completed</h2></center>
        <?php
            $uid= $_SESSION['userid'];
            $minfail=0;
            $minsucces=0;
            $minwaiting=0;
            $total=0;
            $sqlfail="select * from post where fk_Personid_Person ='$uid' and datetime_from > '$date' and datetime_from < '$tomorrow' and status='4'";
            $sqlsucces="select * from post where fk_Personid_Person ='$uid' and datetime_from > '$date' and datetime_from < '$tomorrow' and status='2'";
            $sqlwaiting="select * from post where fk_Personid_Person ='$uid' and datetime_from > '$date' and datetime_from < '$tomorrow' and status='1'";
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
            ?>

<center><p style="font-size:40px;"><?php echo $percent;?>%</p></center>
    </div>


    <?php while($row = mysqli_fetch_array($data)) {

    $dfrom=$row['datetime_from'];
    $dto=$row['datetime_to'];
    $text=$row['text'];
    $status=$row['status'];
    $postid=$row['id_Post'];
    if (  $status==1  )
        {
            $color="#1affff";
        }
        elseif ($status==2)
            {
                $color="green";
            }
            else{$color="red";}
    $date = strtotime($dfrom);
    $date2 = strtotime($dto);
    $hoursfrom = date('H', $date);
    $hoursfrom2 = date('h', $date);
    $minfrom = date('i', $date);
    $allfrom =($hoursfrom*60+$minfrom)/2;
   // $allfrom=$allfromtocount-$allfrom;

    $hoursto=date('H', $date2);
    $hoursto2=date('2', $date2);
    $minto=date('i', $date2);
    $allto= ($hoursto*60+$minto)/2;
   // $allto=$alltotocount-$allto;

    //var_dump($alltotocount);
    $height=$allto-$allfrom;
    ?>
    <div  id="row1" style="top: <?php echo $allfrom?>px; left:<?php echo $left?>px;  height: <?php echo $height;?>px;  background-color:<?php echo $color?>; " onclick='divclick(<?php echo $postid ?>);' >


      <span style="font-size:10px;"> <?php if (  $allfrom<360 )
        {echo "$hoursfrom2:$minfrom am- $hoursto2:$minto am";}
        else{echo "$hoursfrom2:$minfrom pm- $hoursto2:$minto pm";}?></span>
        <span style="font-size:15px;"> <?php echo"$text";?></span>
    </div>
    <?php
    }
    ?>



</div>


<script>
    function divclick(x){

        alert("div is clicked ");
        window.location.href = "../public/Editpost?postid="+x;
    };
</script>
</body>

</html>






