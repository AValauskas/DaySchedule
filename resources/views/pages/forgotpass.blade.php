<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
    <title>Negali prisijungti</title>
    <link href="include/styles.css" rel="stylesheet" type="text/css" >
</head>
<body style ="background: linear-gradient()">



<div align="center">
    <table> <tr><td>
                <center style="font-size:18pt;"><b>User <?php echo $_SESSION['name_login']; ?> can't connect</b></center>
            </td></tr>
        <tr><td>
                <p>if you click continue changed password will be sent to your email</p>
                <table class="center">



                    <form class="" action="{{URL::to('/changepass')}}" method="get">
                        @csrf
                        <input type="email" name="mail" placeholder="write your mail" value="" required><br>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="submit" name="login" value="Continue">
                    </form>
                    <br>
                        <?php
                    if ( isset($_SESSION["mailerror"])   )
                        {
                            $wrong=$_SESSION["mailerror"];
                            echo "$wrong";
                            $_SESSION["mailerror"]=null;

                        }

                    ?>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>