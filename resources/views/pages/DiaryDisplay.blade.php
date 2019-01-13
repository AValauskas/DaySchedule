@include('pages.Menu')
        <!DOCTYPE html>

<?php
$uid= $_SESSION['userid'];
$dbc = database();
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
<div>
    <div class="row">
        <div class="col-lg-3">
            @include('pages.SideMenu')
        </div>
        <div class="col-lg-9">
            <div class='row' id=date_info>
                <div class=col-lg-1>
                    bem
                </div>
                <div class=col-lg-8>
                    bem
                </div>
                <div class=col-lg-2 style="font-size: 100%;">
                    bem
                </div>
                <div class=col-lg-1>
                    bem
                </div>
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

        </div>
    </div>
</div>
</body>


</html>