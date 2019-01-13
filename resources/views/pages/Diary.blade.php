@include('pages.Menu')
        <!DOCTYPE html>

<?php
$dbc = database();
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
<head>
    <title>Diary</title>

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
        .btn{
            text-transform: uppercase;
            color: white;
            background-color: #353535;
        }
        .btn:hover{
            color: #1b1e21;
            background-color: gray;
        }
        .edit{
            background: white;
        }
        p.error{
            text-transform: uppercase;
            color: green;
        }
        .form-group{
            width: 50%;
            margin: auto;
        }
    </style>
</head>
<body>
<?php
if (isset($_SESSION['diarytext']))
    {
        $idd=$row['id_Diary'];
        ?>
<div>
    <div class="row" style="margin-right: 0px;margin-left: 0px;">
        <div class="col-lg-3" style="padding-right: 0px;padding-left: 0px;">
            @include('pages.SideMenu')
        </div>
        <div class="col-lg-9" style="padding-right: 0px;padding-left: 0px;">
            <div class='row' style="margin-right: 0px;margin-left: 0px;" id=date_info>
                <div class="col-lg-10" style="font-size: 40px; margin-top: 10px;padding-right: 0px;padding-left: 0px;">
                    EDIT DIARY
                </div>
                <div class="col-lg-2" style="font-size: 40px; margin-top: 10px;padding-right: 0px;padding-left: 0px;">
                    <?php echo" <a href=../public/deletediaryDay?id=",urlencode($idd),"><input type=button class='btn btn-lg' id='$idd' value='Delete diary' ></a> " ?>
                </div>
            </div>
            <div class="edit">
        <form class="" action="{{URL::to('/editdiary')}}" method="get">
            @csrf
            <br>
            <div class="form-group" style="text-align: center">
                <div class="col-lg-12">
                    Text
                    <textarea type="text" style="width: inherit;height: 200px" name="text" rows="4" cols="50" value="" required><?php echo $_SESSION['diarytext'] ?></textarea>
                </div>
            </div>
            <div class="form-group" style="text-align: center">
                <div class="col-lg-12">
                    <p class="error">
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
                    </p>
                </div>
            </div>
            <div class="row" style="text-align: center; padding-bottom: 20px;">
                <div class="col-lg-12">
                    <input type="hidden" name="fk" value="<?php echo $row['id_Diary']?>">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type=submit class="btn btn-lg" name="button">UPDATE</button>
                </div>
            </div>
        </form>
    </div>
</div>

        <?php
    }else{
    ?>
        <div>
            <div class="row" style="margin-right: 0px;margin-left: 0px;">
                <div class="col-lg-3" style="padding-right: 0px;padding-left: 0px;">
                    @include('pages.SideMenu')
                </div>
                <div class="col-lg-9" style="padding-right: 0px;padding-left: 0px;">
                    <div class='row' style="margin-right: 0px;margin-left: 0px;" id=date_info>
                        <div class="col-lg-12" style="font-size: 40px; margin-top: 10px;padding-right: 0px;padding-left: 0px;">
                            ADD DIARY
                        </div>
                    </div>
                    <div class="edit">
        <form class="" action="{{URL::to('/adddiary')}}" method="get">
            @csrf
            <br>
            <div class="form-group" style="text-align: center">
                <div class="col-lg-12">
                    <textarea style="width: inherit;height: 200px"type="text" name="text" value="" required></textarea>
                </div>
            </div>
            <div class="form-group" style="text-align: center">
                <div class="col-lg-12">
                    <p class="error">
                        <?php
                        if (isset($_SESSION['diaryremoved']))
                        {
                            $success=$_SESSION['diaryremoved'];
                            echo "$success";
                            $_SESSION['diaryremoved']=null;

                        }
                        ?>
                    </p>
                </div>
            </div>
            <div class="row" style="text-align: center; padding-bottom: 20px;">
                <div class="col-lg-12">
                    <input type="hidden" name="fk" value="<?php echo $row['id_Diary']?>">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type=submit class="btn btn-lg" name="button">ADD</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
    }
    ?>


</body>


</html>