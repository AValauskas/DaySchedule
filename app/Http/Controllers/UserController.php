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


                    $sql="insert into person(name,email, username, password,userlevel) values('$name','$mail','$username','$password','$userlevel')";
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

                    $sql = "UPDATE person SET timestamp='$time' WHERE  username='$username'";
                    if (!mysqli_query($dbc, $sql)) {
                        echo " DB klaida įrašant timestamp: " . $sql . "<br>" . mysqli_error($dbc);
                        exit;}
                    $sql2 = "select * from person where username='$username'";
                    $data = mysqli_query($dbc, $sql2);

                    $row = mysqli_fetch_assoc($data);
                    $_SESSION['name']=$row['name'];
                    $_SESSION['mail']=$row['email'];

                    $_SESSION['user']=$username;
                    $_SESSION['message']="";
                    return redirect('/Main');
                }
            }
        }
        return redirect('/login');
    }


    public function continue(request $request)
    {
        if(empty($_SESSION["user"]))
        {
            return redirect('/welcome');
        }
        else{
            return redirect('/Main');
        }

    }

    public function logout(request $request)
    {
        session_unset();
        return redirect('/');
    }


    public function editinfo(request $request)
    {

        $pass = $request->input('password');
        $pass2 = $request->input('password2');
        $mail = $request->input('mail');
        $uid= $_SESSION['userid'];
        $dbc = mysqli_connect('localhost', 'root', '', 'schedule');
        if (!$dbc) {
            die ("Can't connect to MySQL:" . mysqli_error($dbc));
        }
        if ( $pass=='')
        {
            if (  checkmail($mail)  )
            {
                $sql="update person set email='$mail' where id_Person='$uid'";
                if (mysqli_query($dbc, $sql))
                {$_SESSION['message']="Sucesfully edited";
                    inisession();
                    return redirect('/editcustomerinfo');
                }
                else {$_SESSION['message']="DB registracijos klaida:" . $sql . "<br>" . mysqli_error($dbc);}
            }
        }
        elseif ( $pass==$pass2  )
        {

            if (checkpass($pass,substr(hash('sha256',$pass),5,32))  && checkmail($mail)) // antra tikrinimo dalis checkpass bus true
            {
                $pass=substr(hash('sha256',$pass),5,32);
                $sql="update person set password='$pass',email='$mail' where id_Person='$uid'";
                if (mysqli_query($dbc, $sql))
                {$_SESSION['message']="Sucesfully edited";
                    inisession();
                    return redirect('/login');
                }
                else {$_SESSION['message']="DB registracijos klaida:" . $sql . "<br>" . mysqli_error($dbc);}
            }
            else{
                $_SESSION["error"]="password or email incorect format";
                return redirect('/editcustomerinfo');
            }

        }
        else{
            $_SESSION["error"]="Passwords isnt's  similiar";
            return redirect('/editcustomerinfo');
        }
    }



}
