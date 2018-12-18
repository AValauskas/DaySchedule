<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
session_start();
class UserController extends Controller
{


    function checkname ($username){
        $a="yra";
        var_dump($a);
        die;// Vartotojo vardo sintakse
        if (!$username || strlen($username = trim($username)) == 0)
        {$_SESSION['name_error']=
            "<font size=\"2\" color=\"#ff0000\">* Neįvestas vartotojo vardas</font>";
            "";
            return false;}
        elseif (!preg_match("/^([0-9a-zA-Z])*$/", $username))  /* Check if username is not alphanumeric */
        {$_SESSION['name_error']=
            "<font size=\"2\" color=\"#ff0000\">* Vartotojo vardas gali būti sudarytas<br>
				&nbsp;&nbsp;tik iš raidžių ir skaičių</font>";
            return false;}
        else return true;
    }

    function checkpass($pwd,$dbpwd) {     //  slaptazodzio tikrinimas (tik demo: min 4 raides ir/ar skaiciai) ir ar sutampa su DB esanciu

        if (!$pwd || strlen($pwd = trim($pwd)) == 0)
        {$_SESSION['pass_error']=
            "<font size=\"2\" color=\"#ff0000\">* Neįvestas slaptažodis</font>";
            return false;}
        elseif (!preg_match("/^([0-9a-zA-Z])*$/", $pwd))  /* Check if $pass is not alphanumeric */
        {$_SESSION['pass_error']="* Čia slaptažodis gali būti sudarytas<br>&nbsp;&nbsp;tik iš raidžių ir skaičių";
            return false;}
        elseif (strlen($pwd)<4)  // per trumpas
        {$_SESSION['pass_error']=
            "<font size=\"2\" color=\"#ff0000\">* Slaptažodžio ilgis <4 simbolius</font>";
            return false;}
        elseif ($dbpwd != substr(hash( 'sha256', $pwd ),5,32))
            //elseif ($dbpwd != $pwd)
        { //var_dump($dbpwd);
            //  xdebug_break();
            $_SESSION['pass_error']=
                "<font size=\"2\" color=\"#ff0000\">* Neteisingas slaptažodis</font>";
            return false;}
        else return true;
    }

    function checkdb($username) {  // iesko DB pagal varda, grazina {vardas,slaptazodis,lygis,id} ir nustato name_error
        $db=mysqli_connect('localhost', 'root', '', 'schedule');
        $sql = "SELECT * FROM asmuo WHERE username = '$username'";
        $result = mysqli_query($db, $sql);
        var_dump($result);
        $uname = $upass = $ulevel = $uid = $umail = null;
        if (!$result || (mysqli_num_rows($result) != 1))   // jei >1 tai DB vardas kartojasi, netikrinu, imu pirma
        {  // neradom vartotojo DB
            $_SESSION['name_error']=
                "<font size=\"2\" color=\"#ff0000\">* Tokio vartotojo nėra</font>";
        }
        else {  //vardas yra DB
            $row = mysqli_fetch_assoc($result);
            $uname= $row["username"]; $upass= $row["password"];
            $ulevel=$row["userlevel"]; $uid= $row["id_Asmuo"]; $umail = $row["email"];}
        return array($uname,$upass,$ulevel,$uid,$umail);
    }

    function checkmail($mail) {   // e-mail sintax error checking
        if (!$mail || strlen($mail = trim($mail)) == 0)
        {$_SESSION['mail_error']=
            "<font size=\"2\" color=\"#ff0000\">* Neįvestas e-pašto adresas</font>";
            return false;}
        elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL))
        {$_SESSION['mail_error']=
            "<font size=\"2\" color=\"#ff0000\">* Neteisingas e-pašto adreso formatas</font>";
            return false;}
        else return true;
    }

    public function store(request $request)
    {
        $name=strtolower($request->input('name'));
        $username=$request->input('login');
        $password=$request->input('password');
        $mail=$request->input('mail');
        $userlevel=1;

        $dbc = mysqli_connect('localhost', 'root', '', 'schedule');
        if (!$dbc) {
            die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
        }


        if (checkname($username))
        {
            list($dbuname)=checkdb($username);

            if ($dbuname)  {  // jau yra toks vartotojas DB
                $_SESSION['name_error']=
                    "<font size=\"2\" color=\"#ff0000\">* Tokiu vardu jau yra registruotas vartotojas</font>";
            } else {  // gerai, vardas naujas
                $_SESSION['name_error'] = "";
                if (checkpass($password,substr(hash('sha256',$password),5,32))  && checkmail($mail)) // antra tikrinimo dalis checkpass bus true
                {

                    $password=substr(hash('sha256',$password),5,32);
                    $sql="insert into asmuo(vardas,el_pastas, prisijungimo_vardas, slaptazodis,userlevel) values('$name','$mail','$username','$password','$userlevel')";
                    if (mysqli_query($dbc, $sql))
                    {$_SESSION['message']="Registracija sėkminga";
                        return redirect('/login');
                    }
                    else {$_SESSION['message']="DB registracijos klaida:" . $sql . "<br>" . mysqli_error($dbc);}

                }




            }

        }
        return redirect('/registration');





    }


}
