@include('pages.Menu')
<!DOCTYPE html>


<?php
        if ( isset($_GET['dt'])   )
            {
                $datefromtoprint = new DateTime($_GET['dt']);
                $date=$datefromtoprint->format('Y-m-d\TH:i');
                $_SESSION['date_from']=$date;
                $_SESSION['date_to']=$date;
            }
?>


<html>

<head>
    <title>Add Post</title>

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
</head>
<body>
<div>
    <div class="row" style="margin-right: 0px;margin-left: 0px;">
        <div class="col-lg-3" style="padding-right: 0px;padding-left: 0px;">
            @include('pages.SideMenu')
        </div>
        <div class="col-lg-9" style="padding-right: 0px;padding-left: 0px;">
            <div class='row' style="margin-right: 0px;margin-left: 0px;" id=date_info>
                <div class="col-lg-12" style="font-size: 40px; margin-top: 10px;padding-right: 0px;padding-left: 0px;">
                    ADD POST
                </div>
            </div>
            <div class="edit">
        <form class="" action="{{URL::to('/addaction')}}" method="get">
            @csrf
                <br>
                <div class="form-group" style="text-align: center">
                    <div class="col-lg-12">
                        Date From
                        <input type="datetime-local" name="date_from"  class="form-control"value="<?php  if(isset($_SESSION['date_from'])){echo $_SESSION["date_from"];$_SESSION["date_from"]=null;}  ?>"   required><br>
                    </div>
                </div>
            <div class="form-group" style="text-align: center">
                <div class="col-lg-12">
                    Date To
                    <input type="datetime-local" name="date_to" class="form-control" value="<?php if(isset($_SESSION['date_to'])){ echo $_SESSION["date_to"];$_SESSION["date_to"]=null;}  ?>" required><br>
                </div>
            </div>
            <div class="form-group" style="text-align: center">
                <div class="col-lg-12">
                    TITLE
                    <input type="text" name="action" class="form-control" value="<?php if(isset($_SESSION['action'])){echo $_SESSION["action"]; $_SESSION["action"]=null;}  ?>" required/><br>
                </div>
            </div>
            <div class="form-group" style="text-align: center">
                <div class="col-lg-12">
                    <select class="btn btn-lg" name="category">
                        <option value="1">Science</option>
                        <option value="2">Job</option>
                        <option value="3">Sports</option>
                        <option value="4">Freetime</option>
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
                            echo "$wrong" ;
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
                    <button type=submit class="btn btn-lg" name="button">SUBMIT</button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
</div>
</body>


</html>