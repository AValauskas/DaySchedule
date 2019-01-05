@include('pages.Menu')
        <!DOCTYPE html>

<?php
$dbc = mysqli_connect('localhost', 'root', '', 'schedule');
if (!$dbc) {
    die ("Can't connect to MySQL:" . mysqli_error($dbc));
}
$data = date("Y-m-d");
$uid= $_SESSION['userid'];
 $sql="select * from diary where date='$data' and fk_Personid_Person='$uid' ";
$data = mysqli_query($dbc, $sql);

$row = mysqli_fetch_assoc($data);

if (isset($row['text']))
    {
        $_SESSION['diarytext']=$row['text'];
    }
    else{
        $_SESSION['diarytext']=null;
    }




?>

<html>
<body>
<?php
if (isset($_SESSION['diarytext']))
    {
        $idd=$row['id_Diary'];
        ?>
<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <form class="" action="{{URL::to('/editdiary')}}" method="get">
            @csrf
            <h3>Edit Diary</h3><br>
            <div>
                <h2>Diary</h2> <textarea type="text" name="text" rows="4" cols="50" value="" required><?php echo $_SESSION['diarytext'] ?></textarea>
            </div>
            <br>
            <?php

            if (isset($_SESSION['diaryadded']))
            {
                $success=$_SESSION['diaryadded'];
                echo "$success";
                $_SESSION['diaryadded']=null;

            }

            if (isset($_SESSION['diaryupdated']))
            {
                $success=$_SESSION['diaryupdated'];
                echo "$success";
                $_SESSION['diaryupdated']=null;
            }
            ?>
            <br>
            <input type="hidden" name="fk" value="<?php echo $row['id_Diary']?>">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <button type=submit name="button">Patvirtinti</button>

        </form>
    </div>
    <?php echo" <a href=../public/deletediary?id=",urlencode($idd),"><input type=button id='$idd' value='Delete diary' ></a> " ?>
</div>

        <?php
    }else{
    ?>
<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <form class="" action="{{URL::to('/adddiary')}}" method="get">
            @csrf
            <h3>Add Diary</h3><br>
            <div>
                <h2>Diary</h2> <textarea type="text" name="text" rows="4" cols="50" value="" required></textarea>
            </div>
            <br>
            <?php
            if (isset($_SESSION['diaryremoved']))
            {
                $success=$_SESSION['diaryremoved'];
                echo "$success";
                $_SESSION['diaryremoved']=null;

            }
            ?>
            <br>
            <input type="hidden" name="fk" value="<?php echo $row['id_Diary']?>">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <button type=submit name="button">Patvirtinti</button>

        </form>
    </div>
</div>

<?php
    }
    ?>


</body>


</html>