<!DOCTYPE html>

<?php

?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Registration</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="{{URL::asset('/css/Welcome.css')}}" rel="stylesheet" type="text/css" >
    <style>
        body{
            text-align:center;
            background:url({{url('images/Background.png')}}) no-repeat center fixed;
            background-size: cover;
        }
    </style>
</head>

<html>
<body>
<div>
    <img src="{{URL::asset('/images/GoSchedule.png')}}">
</div>
<div class="container">
    <p>
        REGISTER
    </p>
    <div>
        <form action="{{URL::to('/store')}}" method="post">
            @csrf
            <div class=form-group">
            <input type="text" name="name" placeholder="Name" class="form-control" value="<?php echo $_SESSION['name'] ?>" required><br>
            </div>

            <div class=form-group">
            <input type="text" name="login" placeholder="Username" class="form-control" value="<?php echo $_SESSION['name_login'] ?>" required><br>
            <?php echo $_SESSION['name_error']; ?>
            </div>

            <div class=form-group">
            <input type="password" name="password" placeholder="Password" class="form-control" value="" required><br>
            <?php echo $_SESSION['pass_error']; ?>
            </div>

            <div class=form-group">
            <input type="email" name="mail" placeholder="Email" class="form-control" value="<?php  echo $_SESSION['mail_login'] ?>" required><br>
            <?php echo $_SESSION['mail_error']; ?>
            </div>

            <div class=form-group">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            </div>

            <button type=submit class="btn btn-lg" name="button">REGISTER</button>
        </form>
    </div>
    <br>
    <br>
</div>
</body>
</html>