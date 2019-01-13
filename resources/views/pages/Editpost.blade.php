@include('pages.Menu')

<!DOCTYPE html>

<html>

<title>Edit Post</title>
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
        color: red;
    }
    .form-group{
        width: 22%;
        margin: auto;
    }
</style>

<body>


<?php

$dbc = database();

$id = $_GET['postid'];
$sql ="select * from post where id_Post='$id'";
$data = mysqli_query($dbc, $sql);
$row = mysqli_fetch_array($data);


$_SESSION["date_from"]=$row['datetime_from'];
$_SESSION["date_to"]=$row['datetime_to'];

$ch=$_SESSION["date_from"];
$ch2=$_SESSION["date_to"];
$_SESSION["date_to"]=$row['datetime_to'];
$_SESSION["action"]=$row['text'];

$datefromtoprint = new DateTime($ch);
$datetotoprint = new DateTime($ch2);

$datefrom = strtotime($ch);

$today= date('Y-m-d\TH:i');

$time1 = strtotime($ch2);
$time2 = strtotime($today);

?>

<body>
<div>
    <div class="row" style="margin-right: 0px;margin-left: 0px;">
        <div class="col-lg-3" style="padding-right: 0px;padding-left: 0px;">
            @include('pages.SideMenu')
        </div>
        <div class="col-lg-9" style="padding-right: 0px;padding-left: 0px;">
            <div class='row' style="margin-right: 0px;margin-left: 0px;" id=date_info>
                <div class="col-lg-8" style="font-size: 40px; margin-top: 10px;padding-right: 0px;padding-left: 0px;">
                    EDIT POST
                </div>
                <div class="col-lg-2" style="font-size: 40px; margin-top: 10px;padding-right: 0px;padding-left: 0px;">
                    <?php if ($time1<=$time2){?>

                    <form class="" action="{{URL::to('/poststatus')}}" method="get">
                        @csrf
                        <select class="btn btn-lg" name="poststat" onchange="this.form.submit()">
                            <option value="no"  disabled selected>status</option>
                            <option value="2">done</option>
                            <option value="4">failed</option>
                        </select>
                        <input type="hidden" name="fk" value="{{$id}}">
                        <input type="hidden" name="dat" value="{{ $datefromtoprint->format('Y-m-d')}}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                    </form>
                    <?php  } ?>
                </div>
                <div class="col-lg-2" style="font-size: 40px; margin-top: 10px;padding-right: 0px;padding-left: 0px;">
                    <form class="" action="{{URL::to('/deletepost')}}" method="get">
                        @csrf
                        <input type="hidden" name="fk" value="{{$id}}">
                        <input type="hidden" name="dat" value="{{ $datefromtoprint->format('Y-m-d')}}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type=submit class="btn btn-lg" name="button">Delete</button>
                    </form>
                </div>
            </div>
            <div class="edit">
        <form class="" action="{{URL::to('/editaction')}}" method="get">
            @csrf
            <br>
            <div class="form-group" style="text-align: center">
                <div class="col-lg-12">
                    Date From
                    <input type="datetime-local" class="form-control" name="date_from" value="<?php echo $datefromtoprint->format('Y-m-d\TH:i');?>"   required><br>
                </div>
            </div>
            <div class="form-group" style="text-align: center">
                <div class="col-lg-12">
                    Date To
                    <input type="datetime-local" class="form-control" name="date_to" value="<?php echo $datetotoprint->format('Y-m-d\TH:i');?>" required><br>
                </div>
            </div>
            <div class="form-group" style="text-align: center">
                <div class="col-lg-12">
                    Title
                    <input type="text" class="form-control" name="action" value="<?php echo $_SESSION["action"];  ?>" required/><br>
                </div>
            </div>
            <div class="form-group" style="text-align: center">
                <div class="col-lg-12">
                    <select class="btn btn-lg" name="kind">
                        <option value="1">science</option>
                        <option value="2">job</option>
                        <option value="3">sport</option>
                        <option value="4">freetime</option>
                    </select >
                </div>
            </div>
            <div class="form-group" style="text-align: center">
                <div class="col-lg-12">
                    <p class="error">
                        <?php
                        if(isset($_SESSION['error']))
                        {
                            $wrong=$_SESSION['error'];
                            echo "$wrong";
                            $_SESSION['error']=null;
                        }


                        if (isset($_SESSION['message']))
                        {
                            $success=$_SESSION['message'];
                            echo "$success";
                            $_SESSION['message']=null;

                        }
                        ?>
                    </p>
                </div>
            </div>
            <div class="row" style="text-align: center; padding-bottom: 20px;">
                <div class="col-lg-12">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="fk" value="{{$id}}">
                    <button type=submit class="btn btn-lg" name="button">UPDATE</button>
                </div>
            </div>
        </form>
    </div>
</div>

</body>


</body>




</html>