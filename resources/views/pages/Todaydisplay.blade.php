@include('pages.Menu')
        <!DOCTYPE html>
<style>
    .container-fluid{
        font-family: "Century Gothic";
    }
    .row#date_info{
        background: #f7e6ad;
        margin-bottom: 0px;
        padding-bottom: 0px;
        height: 75px;
        width: 100%;
        font-size: 400%;
        text-align: center;
        text-transform: uppercase;
    }
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
$sqlfind ="select * from post where datetime_from > '$date' and datetime_from < '$tomorrow'or (datetime_to > '$date' and datetime_to < '$tomorrow' ) order by datetime_from";
$data = mysqli_query($dbc, $sqlfind);
$allfrom=0;
$allto=0;
$height=0;
$left=202;
$count=0;
$getday = strtotime($date);
$day = date('d', $getday);
?>

<?php
$range = hoursRange();

?>
<div class="container-fluid" style="padding-right: 0px;padding-left: 0px;">
    <div class="row" style="margin-right: 0px;margin-left: 0px;">
        <div class="col-lg-3" style="padding-right: 0px;padding-left: 0px;">
            @include('pages.SideMenu')
        </div>
<div class="col-lg-9" style="padding-right: 0px;padding-left: 0px;">
    <div>
        <div class='row' style="margin-right: 0px;margin-left: 0px;" id=date_info>
            <div class=col-lg-1 >
                <a href="?ymd=<?= $prev; ?>" class="btn btn-link arrow" style="color: black;font-size: 50px">&lt;</a>
            </div>
            <div class=col-lg-8>
                <?php echo "$date" ?>
            </div>
            <div class=col-lg-2 style="font-size: 100%;">
                <a href="../public/Day" style="color: black;font-size: 30px" class="btn btn-link">ADD POST</a>
            </div>
            <div class=col-lg-1>
                <a href="?ymd=<?= $tomorrow; ?>" class="btn btn-link arrow" style="color: black;font-size: 50px"> &gt;</a>
            </div>
        </div>
        <?php foreach( $range as $item){
        ?>
        <div class="row" style="margin-right: 0px;margin-left: 0px;">
            <div class="col-sm-2"  style="background: white;height: 30px; border-right: 1px solid #cecece; ">
                <?php echo"$item"; ?>

            </div>

            <div class="col-sm-10" style="background-color:white; border-style: solid; border-width: 1px; border-color: #cecece;height: 30px;  ">

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
            $percent=Efficiencycalculate($date,$tomorrow);
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
    var_dump($date);
    var_dump($dfrom);
    $date = strtotime($dfrom);
    $date2 = strtotime($dto);
    $hoursfrom = date('H', $date);
    $hoursfrom2 = date('h', $date);
    $minfrom = date('i', $date);

   // $allfrom=$allfromtocount-$allfrom;
    $dayfrom = date('d', $date);
    $dayto = date('d', $date2);
    $hoursto=date('H', $date2);
    $hoursto2=date('h', $date2);

    if (  $hoursto<$hoursfrom && $day==$dayfrom )
        {
            var_dump("labas");
            $hoursto=24;
            $minto=0;
        }
        elseif($hoursto<$hoursfrom && $day==$dayto ){
            $hoursfrom=0;
            $minfrom=0;
            $minto=date('i', $date2);
        }
    $allfrom =($hoursfrom*60+$minfrom)/2;
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
</div>
</div>


<script>
    function divclick(x){

        alert("div is clicked ");
        window.location.href = "../public/Editpost?postid="+x;
    };
</script>
</body>

</html>






