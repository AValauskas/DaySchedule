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
        div.journal{
            background: white;
            max-height: 80vh;
            overflow: auto;
        }
        .btn{
            text-transform: uppercase;
            color: white;
            background-color: #353535;
        }
        .btn:hover{
            color: #1b1e21;
            background-color: gray;
        }
        td.diaryPost {
            min-width: 100px;
            overflow: auto;
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
    <div class="row" style="margin-right: 0px;margin-left: 0px;">
        <div class="col-lg-3" style="padding-right: 0px;padding-left: 0px;">
            @include('pages.SideMenu')
        </div>
        <div class="col-lg-9" style="padding-right: 0px;padding-left: 0px;">
            <div class='row' id=date_info>
                <form class="date" action="{{URL::to("/DiaryDisplay")}}" method="get">
                    <div class="col-lg-5">
                        FROM
                        <input type="date" name="from" value="<?php echo $from; ?>"/>
                    </div>

                    <div class="col-lg-5">
                        TO
                        <input type="date" name="to"  value="<?php echo $to; ?>" />
                    </div>

                    <div class="col-lg-2">
                        <input class="btn btn-lg" name = "submit" type="submit" value="SHOW">
                    </div>
                </form>
</div>



<div class="journal">
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
        <td class="diaryPost"><?php echo $row['date'];   $idd =$row['id_Diary'];?></td>
        <td class="diaryPost"><?php echo $row['text'];?></td>
        <td class="diaryPost"><?php echo" <a href=../public/Diary?postid=",urlencode($idd),"><input type=button class='btn btn-lg' id='$idd' value='Edit' ></a> " ?></td>
        <td class="diaryPost">  <?php echo" <a href=../public/deletediaryJournal?id=",urlencode($idd),"><input type=button class='btn btn-lg' id='$idd' value='Delete' ></a> " ?></td>
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