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
        width: 100%;
        z-index: 1;
    }
    #row1:hover{
        background-color: yellow;
    }
    div#postName{
        text-align: left;
        white-space: nowrap;
        overflow: hidden;
    }
    div#postTime{
        text-align: right;
        overflow: hidden;
    }
    div#post{
        text-transform: uppercase;
        color: white;
        overflow: hidden;
        font-size: 20px;
    }
    .btn{
        color: white;
        font-size: 20px;
        background-color: #353535;
    }
    .btn:hover{
        color: #1b1e21;
        background-color: gray;
    }
    div.diary{
        margin-right: 5%;
        margin-left: 5%;
        margin-bottom: 2%;
    }
    div#dayDiary{
        background: #f7e6ad;
    }
    p.diaryTitle{
        font-size: 30px;
        text-transform: uppercase;
    }
</style>
<html>

<body>
<?php
$date=$_GET['ymd'];
$dbc = database();
$uid= $_SESSION['userid'];
$today= date("Y-m-d");
$tomorrow=date('Y-m-d', strtotime($date. ' + 1 days'));
$prev=date('Y-m-d', strtotime($date. ' - 1 days'));
//$newformat = date('Y-m-d',$time);
$sqlfind ="select * from post where (datetime_from > '$date' and datetime_from < '$tomorrow'or (datetime_to > '$date' and datetime_to < '$tomorrow' ) or (datetime_from<'$date' and datetime_to>'$date') ) and fk_Personid_Person='$uid' order by datetime_from";
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
            <div class=col-lg-6>
                <?php echo "$date" ?>
            </div>
            <div class=col-lg-2 style="font-size: 85%;">
            <?php
            if( $date==$today ){
            ?>
                <a href="../public/Diary" class="btn btn-lg">Write diary</a>
                <?php }
                ?>
            </div>
            <div class=col-lg-2 style="font-size: 85%;">
                <?php echo" <a href=../public/Day?dt=",urlencode($date),"><input type=button class='btn btn-lg' id='$date' value='ADD POST' ></a> " ?>
            </div>
            <div class=col-lg-1>
                <a href="?ymd=<?= $tomorrow; ?>" class="btn btn-link arrow" style="color: black;font-size: 50px"> &gt;</a>
            </div>
        </div>
        <?php foreach( $range as $item){
        ?>
        <div class="row" style="margin-right: 0px;margin-left: 0px;">
            <div class="col-sm-2"  style="text-align: center;background: white;height: 30px; border-right: 1px solid #cecece; ">
                <?php echo"$item"; ?>

            </div>

            <div class="col-sm-10" style="background-color:white;padding-left: 0px;padding-right: 0px; border-style: solid; border-width: 1px; border-color: #cecece;height: 30px;  ">
                <?php while($row = mysqli_fetch_array($data)) {

                $dfrom=$row['datetime_from'];
                $dto=$row['datetime_to'];
                $text=$row['text'];
                $status=$row['status'];
                $postid=$row['id_Post'];
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
                $date3 = strtotime($dfrom);
                $date2 = strtotime($dto);
                $hoursfrom = date('H', $date3);
                $hoursfrom2 = date('h', $date3);
                $minfrom = date('i', $date3);

                // $allfrom=$allfromtocount-$allfrom;
                $dayfrom = date('d', $date3);
                $dayto = date('d', $date2);
                $hoursto=date('H', $date2);
                $hoursto2=date('h', $date2);
                $minto=date('i', $date2);
                if (  $hoursto<$hoursfrom && $day==$dayfrom )
                {
                    $hoursto=24;
                    $minto=0;
                }
                elseif($hoursto<$hoursfrom && $day==$dayto ){
                    $hoursfrom=0;
                    $minfrom=0;
                }elseif($dayfrom<$day && $dayto>$day)
                {
                    $hoursfrom=0;
                    $minfrom=0;
                    $hoursto=24;
                    $minto=0;
                }
                $allfrom =($hoursfrom*60+$minfrom)/2;
                $allto= ($hoursto*60+$minto)/2;
                // $allto=$alltotocount-$allto;

                //var_dump($alltotocount);
                $height=$allto-$allfrom;
                ?>
                <div  id="row1" style="top: <?php echo $allfrom?>px; min-height: 20px; height: <?php echo $height;?>px;  background-color:<?php echo $color?>; " onclick='divclick(<?php echo $postid ?>);' >
                    <div class="row" id="post">
                        <div class="col-lg-9" id="postName">
                            <?php echo"$text";?>
                        </div>
                        <div class="col-lg-3" id="postTime">
                            <?php if (  $allfrom<360 )
                            {echo "$hoursfrom2:$minfrom am - $hoursto2:$minto am";}
                            else{echo "$hoursfrom2:$minfrom pm - $hoursto2:$minto pm";}?>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>

        </div>

        <div style="background: white">
            <div class="row">
        <?php
        }
        ?>
            <?php

            date_default_timezone_set('UTC');
            //$date = date('Y-m-d H:i:s');
            $hour=date("H");
            $sql="select * from rate where date='$date' and fk_Personid_Person='$uid'";
            $data2 = mysqli_query($dbc, $sql);
            $row = mysqli_fetch_array($data2);
            $value =$row['value'];
            if(($hour>=20 && $date<=$today )|| $date<$today)
            {
                $middle = "col-lg-6";
            ?>
            <div class="col-lg-6" style="text-align: center;font-size: 30px">
                    <form class="" action="{{URL::to('/evaluate')}}" method="get">
                        @csrf
                        DAY EVALUATION
                        <p>
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
                        <button type=submit class='btn btn-lg' name="button">RATE</button>
                        </p>
                    </form>
            </div>
            <?php
            } else {
                $middle = "col-lg-12";
            }
            ?>
<?php    if ($date<=$today) {?>
        <div class="<?php $middle ?>" style="text-align: center;font-size: 30px">
            DAY COMPLETION
             <?php
               $percent=Efficiencycalculate($date,$tomorrow);
              ?>
                <p style="font-size:40px;"><?php echo $percent;?>%</p>
            </div>
            </div>
        </div>
        <?php } ?>
            <div class="row" id="dayDiary">
                <?php
                $sql2="select * from diary where date='$date' and 	fk_Personid_Person='$uid'";
                $data3 = mysqli_query($dbc, $sql2);
                $row = mysqli_fetch_array($data3);
                if(isset($row))
                {
                ?>

                <div class="diary">
                    <div>
                        <p class="diaryTitle">DAY DIARY</p>
                        <?php
                            echo"<p>";
                        $toprint =$row['text'];
                        echo " $toprint </p>";?>
                    </div>
                </div>
                <?php
                }?>
            </div>
        </div>
    </div>

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






