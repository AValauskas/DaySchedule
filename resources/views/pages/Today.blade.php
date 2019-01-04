@include('pages.Menu')
<!DOCTYPE html>

<html>

<body>


<?php
$dbc = mysqli_connect('localhost', 'root', '', 'schedule');
if (!$dbc) {
    die ("Can't connect to MySQL:" . mysqli_error($dbc));
}

$today= date("Y-m-d");
$tomorrow=date('Y-m-d', strtotime($today. ' + 1 days'));
//$newformat = date('Y-m-d',$time);
$sqlfind ="select * from post where datetime_from > '$today' and datetime_from < '$tomorrow' order by datetime_from";
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
    <tbody>
    <?php
    while($row = mysqli_fetch_array($data)) {?>
    <tr>
        <td><?php echo $row['datetime_from'];   $idd =$row['id_Post'];?></td>
        <td><?php echo $row['datetime_to'];?></td>
        <td><?php echo $row['text'];?></td>
        <td><?php echo $row['category'];?></td>
        <td><?php echo" <a href=../public/Editpost?postid=",urlencode($idd),"><input type=button id='$idd' value='Edit' ></a> " ?></td>
        <td><?php echo" <a href=../public/deletepost?id=",urlencode($idd),"><input type=button id='$idd' value='delete' ></a> " ?></td>
    </tr>


    <?php }?>

    </tbody>
</table>




</body>




</html>