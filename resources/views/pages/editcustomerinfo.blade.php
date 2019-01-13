@include('pages.Menu')
        <!DOCTYPE html>

<?php

?>

<head>
    <title>Edit User</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
            width: 20%;
            margin: auto;
        }
    </style>
</head>

<html>
<body>

<div>
    <div class="row" style="margin-right: 0px;margin-left: 0px;">
        <div class="col-lg-3" style="padding-right: 0px;padding-left: 0px;">
            @include('pages.SideMenu')
        </div>
        <div class="col-lg-9" style="padding-right: 0px;padding-left: 0px;">
        <div class='row' style="margin-right: 0px;margin-left: 0px;" id=date_info>
            <div class="col-lg-12" style="font-size: 40px; margin-top: 10px;padding-right: 0px;padding-left: 0px;">
                EDIT USER INFORMATION
            </div>
        </div>
            <div class="edit">
            <form class="" action="{{URL::to('/editinfo')}}" method="get">
                @csrf
                <br>
                <div class="form-group" style="text-align: center">
                    <div class="col-lg-12">
                        <input type="text" name="name" placeholder="Name" class="form-control" value="<?php echo $_SESSION['name'] ?>" readonly="readonly"><br>
                    </div>
                </div>
                <div class="form-group" style="text-align: center">
                    <div class="col-lg-12">
                        <input type="text" name="login" placeholder="Login" class="form-control" value="<?php echo $_SESSION['name_login'] ?>" readonly="readonly"><br>
                    </div>
                </div>
                <div class="form-group" style="text-align: center">
                    <div class="col-lg-12">
                        <input type="password" name="password" class="form-control" placeholder="Password" value=""><br>
                        <?php echo $_SESSION['pass_error']; ?>
                    </div>
                </div>
                <div class="form-group" style="text-align: center">
                    <div class="col-lg-12">
                        <input type="password" name="password2" class="form-control" placeholder="Repeat Password" value=""><br>
                        <?php echo $_SESSION['pass_error']; ?>
                    </div>
                </div>
                <div class="form-group" style="text-align: center">
                    <div class="col-lg-12">
                        <input type="email" name="mail" placeholder="Email" class="form-control" value="<?php  echo $_SESSION['mail'] ?>" required><br>
                        <?php echo $_SESSION['mail_error']; ?>
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
                            ?>
                        </p>
                    </div>
                </div>
                <div class="row" style="text-align: center; padding-bottom: 20px;">
                    <div class="col-lg-12">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type=submit class="btn btn-lg" name="button">UPDATE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</body>
</html>