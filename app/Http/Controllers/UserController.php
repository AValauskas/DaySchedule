<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{




    public function store(request $request)
    {
        $name=$request->input('name');
        $username=strtolower($request->input('login'));
        $password=$request->input('password');
        $mail=$request->input('mail');
        $userlevel=1;
        $_SESSION['name_login']=$name;
        $_SESSION['pass_login']=$password;
        $_SESSION['mail_login']=$mail;
        $_SESSION['name']=$name;

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


                    $sql="insert into asmuo(name,email, username, password,userlevel) values('$name','$mail','$username','$password','$userlevel')";
                    if (mysqli_query($dbc, $sql))
                    {$_SESSION['message']="Registracija sėkminga";
                        inisession();
                        return redirect('/login');
                    }
                    else {$_SESSION['message']="DB registracijos klaida:" . $sql . "<br>" . mysqli_error($dbc);}

                }

            }
        }
        return redirect('/registration');

    }


    public function log(request $request)
    {
        $_SESSION['name_error']="";
        $_SESSION['pass_error']="";
        $username=strtolower($request->input('login'));

        $_SESSION['name_login']=$username;


        if (checkname($username)) //vardo sintakse
        {
            list($dbuname,$dbpass,$dblevel,$dbuid,$dbemail)=checkdb($username);
            if ($dbuname) {  //yra vartotojas DB
                $_SESSION['ulevel']=$dblevel;
                $_SESSION['userid']=$dbuid;
                $_SESSION['umail']=$dbemail;

                $password=$request->input('password');
                $_SESSION['pass_login']=$password;

                if (checkpass($password,$dbpass)) {
                    $time=NOW();

                    $dbc = mysqli_connect('localhost', 'root', '', 'schedule');

                    $sql = "UPDATE asmuo SET timestamp='$time' WHERE  username='$username'";
                    if (!mysqli_query($dbc, $sql)) {
                        echo " DB klaida įrašant timestamp: " . $sql . "<br>" . mysqli_error($dbc);
                        exit;}

                    $_SESSION['user']=$username;
                    $_SESSION['message']="";
                    return redirect('/Main');
                }
            }
        }
        return redirect('/login');
    }

}
