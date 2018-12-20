<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<html>
<body>

<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <form class="" action="{{URL::to('/log')}}" method="post">
            @csrf
            <h3>Login</h3><br>

            <input type="text" name="login" placeholder="Login" value="<?php echo $_SESSION['name_login'] ?>" required><br>
            <?php echo $_SESSION['name_error']; ?>
            <br>
            <input type="password" name="password" placeholder="Password" value="" required><br>
            <?php echo $_SESSION['pass_error']; ?>
            <br>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <button type=submit name="button">Patvirtinti</button>
        </form>
    </div>
</div>
</body>
</html>