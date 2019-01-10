@include('pages.Menu')
        <!DOCTYPE html>

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

//$newformat = date('Y-m-d',$time);
$sqlfind ="select * from post where datetime_from > '$date' and datetime_from < '$tomorrow' order by datetime_from";
//var_dump($nowdate);
$data = mysqli_query($dbc, $sqlfind);

?>

<table class="table table-hover" id="myTable">
    <thead>
    <tr class="header">
        <th>date from</th>
        <th>date to</th>
        <th>text</th>
        <th>category</th>
    </tr>

    </thead>
    <tbody>busena
    <?php
    while($row = mysqli_fetch_array($data)) {?>
    <tr>
        <td><?php echo $row['datetime_from'];   $idd =$row['id_Post'];?></td>
        <td><?php echo $row['datetime_to'];?></td>
        <td><?php echo $row['text'];?></td>
        <td><?php echo $row['category'];?></td>
        <td><?php echo" <a href=../public/Editpost?postid=",urlencode($idd),"><input type=button id='$idd' value='Edit' ></a> " ?></td>
        <td><?php echo" <a href=../public/deletepost?id=",urlencode($idd),"><input type=button id='$idd' value='delete' ></a> " ?></td>
        <td>

                    <form class="" action="{{URL::to('/poststatus')}}" method="get">
                        @csrf
                        <select  name="poststat" onchange="this.form.submit()">
                            <option value="no"  disabled selected>status</option>
                            <option value="2">done</option>
                            <option value="4">failed</option>
                        </select>
                        <input type="hidden" name="fk" value="{{$idd}}">
                        <input type="hidden" name="dat" value="{{$date}}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                    </form>

        </td>
    </tr>


    <?php }?>

    </tbody>
</table>


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
?>







</html>






