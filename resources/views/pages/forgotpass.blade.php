<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
    <title>Forgot Password</title>
    <link href="include/styles.css" rel="stylesheet" type="text/css" >
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="{{URL::asset('/css/Welcome.css')}}" rel="stylesheet" type="text/css" >
    <style>
        body{
            text-align:center;
            background:url({{url('images/Background.png')}}) no-repeat center fixed;
            background-size: cover;
        }
        p.error{
            text-transform: uppercase;
            color: red;
            font-size: 15px;
        }
    </style>
</head>

<body>
<div>
    <img src="{{URL::asset('/images/GoSchedule.png')}}">
</div>
<div class="container">
    <p style="font-size: 40px">
        RENEW PASSWORD
    </p>
    <div>
        <form action="{{URL::to('/changepass')}}" method="get">
            @csrf
            <div class=form-group">
                <input type="email" name="mail"  class="form-control" placeholder="ENTER YOUR EMAIL" value="" required><br>
            </div>
            <div class=form-group">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
            </div>
            <div class="row">
                <p class="error">
                    <?php
                    if ( isset($_SESSION["mailerror"])   )
                    {
                        $wrong=$_SESSION["mailerror"];
                        echo "$wrong";
                        $_SESSION["mailerror"]=null;
                    }
                    ?>
                </p>
            </div>
            <div class=form-group">
                <input type="submit" class="btn btn-lg" name="login" value="OK">
            </div>
        </form>
    </div>
</div>
</body>
</html>