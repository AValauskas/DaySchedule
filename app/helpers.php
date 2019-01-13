<?php
session_start();


function database()
{
    $dbc = mysqli_connect('localhost', 'root', '', 'schedule');
  //  $dbc = mysqli_connect('localhost', 'u684378970_sce', 'aurluk', 'u684378970_sce');
    if (!$dbc) {
        die ("Can't connect to MySQL:" . mysqli_error($dbc));
    }
    return $dbc;
}


function inisession() {   //valom sesijos kintamuosius

        $_SESSION['message']="";
        $_SESSION['user']="";
        $_SESSION['ulevel']=0;
        $_SESSION['userid']=0;
        $_SESSION['umail']=0;

    $_SESSION['name_login']="";
    $_SESSION['pass_login']="";
    $_SESSION['mail_login']="";
    $_SESSION['name']="";
    $_SESSION['phone']="";
    if (!isset($_SESSION['name_error']))
    {$_SESSION['name_error']="";}
    if (!isset( $_SESSION['pass_error']))
    { $_SESSION['pass_error']="";}
    if (!isset(  $_SESSION['mail_error']))
    {  $_SESSION['mail_error']="";}

}

function checkname ($username){
if (!$username || strlen($username = trim($username)) == 0)
{$_SESSION['name_error']=
"<font size=\"2\" color=\"#ff0000\">* User name has not been entered</font>";
"";
return false;}
elseif (!preg_match("/^([0-9a-zA-Z])*$/", $username))  /* Check if username is not alphanumeric */
{$_SESSION['name_error']=
"<font size=\"2\" color=\"#ff0000\">* User name can only consist<br>
    &nbsp;&nbsp;of letters and numbers</font>";
return false;}
else return true;
}

function checkpass($pwd,$dbpwd) {     //  slaptazodzio tikrinimas (tik demo: min 4 raides ir/ar skaiciai) ir ar sutampa su DB esanciu

if (!$pwd || strlen($pwd = trim($pwd)) == 0)
{$_SESSION['pass_error']=
"<font size=\"2\" color=\"#ff0000\">* Password has not been entered</font>";
return false;}
elseif (strlen($pwd)<5)  // per trumpas
{$_SESSION['pass_error']=
"<font size=\"2\" color=\"#ff0000\">* Password length must be >= 4</font>";
return false;}
elseif ($dbpwd != substr(hash( 'sha256', $pwd ),5,32))
//elseif ($dbpwd != $pwd)
{ //var_dump($dbpwd);
//  xdebug_break();
$_SESSION['pass_error']=
"<font size=\"2\" color=\"#ff0000\">* Wrong password</font>";
return false;}
else return true;
}

function checkdb($username) {  // iesko DB pagal varda, grazina {vardas,slaptazodis,lygis,id} ir nustato name_error
$db=database();
$sql = "SELECT * FROM person WHERE username = '$username'";
$result = mysqli_query($db, $sql);
var_dump($result);
$uname = $upass = $ulevel = $uid = $umail = null;
if (!$result || (mysqli_num_rows($result) != 1))   // jei >1 tai DB vardas kartojasi, netikrinu, imu pirma
{  // neradom vartotojo DB
$_SESSION['name_error']=
"<font size=\"2\" color=\"#ff0000\">* Wrong username</font>";
}
else {  //vardas yra DB
$row = mysqli_fetch_assoc($result);
$uname= $row["username"]; $upass= $row["password"];
$ulevel=$row["userlevel"]; $uid= $row["id_Person"]; $umail = $row["email"];}
return array($uname,$upass,$ulevel,$uid,$umail);
}

function checkmail($mail) {// e-mail sintax error checking
if (!$mail || strlen($mail = trim($mail)) == 0)
{$_SESSION['mail_error']=
"<font size=\"2\" color=\"#ff0000\">* Email has not been entered</font>";
return false;}
elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL))
{
    $_SESSION['mail_error']=
"<font size=\"2\" color=\"#ff0000\">* Wrong entered email format</font>";
return false;}
else return true;
}

        function hoursRange( $lower = 0, $upper = 86400, $step = 3600, $format = '' ) {
        $times = array();

        if ( empty( $format ) ) {
            $format = 'g:i a';
        }

        foreach ( range( $lower, $upper, $step ) as $increment ) {
            $increment = gmdate( 'H:i', $increment );

            list( $hour, $minutes ) = explode( ':', $increment );

            $date = new DateTime( $hour . ':' . $minutes );

            $times[(string) $increment] = $date->format( $format );
        }

        return $times;
    }

        function Efficiencycalculate($date,$tomorrow)
        {
            $dbc = database();
            $uid= $_SESSION['userid'];
            $minfail=0;
            $minsucces=0;
            $minwaiting=0;
            $total=0;
            $sqlfail="select * from post where fk_Personid_Person ='$uid' and datetime_from > '$date' and datetime_from < '$tomorrow' and status='4'";
            $sqlsucces="select * from post where fk_Personid_Person ='$uid' and datetime_from > '$date' and datetime_from < '$tomorrow' and status='2'";
            $sqlwaiting="select * from post where fk_Personid_Person ='$uid' and datetime_from > '$date' and datetime_from < '$tomorrow' and status='1'";
            $datafail = mysqli_query($dbc, $sqlfail);
            $datasucces = mysqli_query($dbc, $sqlsucces);
            $datawaiting = mysqli_query($dbc, $sqlwaiting);
            while($rowfail = mysqli_fetch_array($datafail))
            {
                $time1 = strtotime($rowfail['datetime_to']);
                $time2 = strtotime($rowfail['datetime_from']);
                $minfail=$minfail+$time1-$time2;

            }
            while($rowsucces = mysqli_fetch_array($datasucces))
            {
                $time1 = strtotime($rowsucces['datetime_to']);
                $time2 = strtotime($rowsucces['datetime_from']);
                $minsucces=$minsucces+$time1-$time2;
            }
            while($rowwaiting = mysqli_fetch_array($datawaiting))
            {
                $time1 = strtotime($rowwaiting['datetime_to']);
                $time2 = strtotime($rowwaiting['datetime_from']);
                $minwaiting=$minwaiting+$time1-$time2;

            }
            $total=$minfail+$minsucces+$minwaiting;
            if ($total>0)
            {
                $percent=round($minsucces/$total*100);

            }else{$percent=0;}

            return $percent;
        }

        function randomPassword()
        {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass); //turn the array into a string
        }



?>