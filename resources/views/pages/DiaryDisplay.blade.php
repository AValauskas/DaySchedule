@include('pages.Menu')
        <!DOCTYPE html>
<head>
    <title>Journal</title>

    <style>
        body{
            font-family: "Century Gothic";
        }
        .row#date_info{
            background: #f7e6ad;
            margin-bottom: 0px;
            padding-bottom: 0px;
            height: 75px;
            width: 100%;
            font-size: 200%;
            text-align: center;
            text-transform: uppercase;
        }
        form.date{
            margin-top: 10px;
        }
    </style>
</head>
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
                <form class="date" action="{{URL::to("/DiaryDisplay")}}" method="get">
                    <input type="date" name="from" value="<?php echo $from; ?>"/><input type="date" name="to"  value="<?php echo $to; ?>" /><input name = "submit" type="submit" value="Rodyti">
                </form>
</div>



<div style="background: white">
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
</div>
</body>


</html>