<?php
inisession();
?>
<!doctype html>
labas
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>GoSchedule</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="{{URL::asset('/css/Welcome.css')}}" rel="stylesheet" type="text/css" >
        <style>
            body{
                text-align:center;
                background:url({{url('images/Background.png')}}) no-repeat center fixed;
                background-size: cover;
            }
        </style>
    </head>
    <body>

    <div>
        <img src="{{URL::asset('/images/GoSchedule.png')}}">
    </div>
        <div class="container">
            @if (Route::has('login'))
                <div>
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            <p>
                LOG IN
            </p>
                <div>
                <form action="{{URL::to('/log')}}" method="post">
                    @csrf
                    <div class=form-group">
                        <input type="text" name="login" placeholder="Username" class="form-control" value="<?php echo $_SESSION['name_login'] ?>" required><br>
                        <?php echo $_SESSION['name_error']; ?>
                    </div>
                    <div class=form-group">
                        <input type="password" name="password" placeholder="Password" class="form-control" value="" required><br>
                        <?php echo $_SESSION['pass_error']; ?>
                    </div>
                    <div class=form-group">
                          <input type="hidden" name="_token" value="{{csrf_token()}}">
                    </div>
                    <div class="row">
                        <button type=submit class="btn btn-lg" name="button">LOG IN</button>
                    </div>
                </form>
                </div>
            <div class="row">
                <a href=../public/registration><input type=button class="btn btn-lg" value='REGISTER'></a>
                <a href=../public/registration><input type=button class="btn btn-lg" id="small" value='FORGOT PASSWORD'></a>
            </div>
            <br>
            <br>
        </div>
    </body>
</html>
