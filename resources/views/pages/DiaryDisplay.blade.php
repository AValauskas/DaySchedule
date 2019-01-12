@include('pages.Menu')
        <!DOCTYPE html>

<?php
$uid= $_SESSION['userid'];
$dbc = mysqli_connect('localhost', 'root', '', 'schedule');
if (!$dbc) {
    die ("Can't connect to MySQL:" . mysqli_error($dbc));
}
if(isset($_GET['from']))
    {
        $from=$_GET['from'];
        $to=$_GET['to'];
        $sql="select * from diary where fk_Personid_Person='$uid' and date >='$from' and date<='$to' order by date ";
    }
    else
        {
            $from="";
            $to="";
            $sql="select * from diary where fk_Personid_Person='$uid' order by date ";
        }


$data = mysqli_query($dbc, $sql);


?>

<html>
<body>

<div class="col-md-6 col-md-offset-3">
    <form class="" action="{{URL::to("/DiaryDisplay")}}" method="get">
        <input type="date" name="from" value="<?php echo $from; ?>"/><input type="date" name="to"  value="<?php echo $to; ?>" /><input name = "submit" type="submit" value="Rodyti">
    </form>
</div>




<table class="table table-hover" id="myTable">
    <thead>
    <tr class="header">
        <th>date</th>
        <th>text</th>

    </tr>

    </thead>
    <tbody>
    <?php
    while($row = mysqli_fetch_array($data)) {?>
    <tr>
        <td><?php echo $row['date'];   $idd =$row['id_Diary'];?></td>
        <td><?php echo $row['text'];?></td>
        <td><?php echo" <a href=../public/Editpost?postid=",urlencode($idd),"><input type=button id='$idd' value='Edit' ></a> " ?></td>
        <td><?php echo" <a href=../public/deletepost?id=",urlencode($idd),"><input type=button id='$idd' value='delete' ></a> " ?></td>
    </tr>


    <?php }?>

    </tbody>
</table>


</body>


</html>