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


    public function addaction(request $request)
    {
        $date_from=$request->input('date_from');
        $date_to=$request->input('date_to');
        $action=$request->input('action');
        $kind=$request->input('kind');
       /* var_dump($date_from);
        var_dump($date_to);
        die;*/

        $_SESSION["date_from"]=$date_from;
        $_SESSION["date_to"]=$date_to;
        $_SESSION["action"]=$action;
        $_SESSION["kind"]=$kind;


        $_SESSION['error']=null;
        $uid= $_SESSION['userid'];
        $date = strtotime($date_from);
        $date2= strtotime($date_to);
        $time=NOW();
        $timenow=strtotime($time);

        if ( $timenow>=  $date )
        {
            $_SESSION['error']="date is passed";
            return redirect('/Day');
        }
        elseif ($date>=$date2)
        {
            $_SESSION['error']="wrong date";
            return redirect('/Day');
        }
        else {
            $dbc = mysqli_connect('localhost', 'root', '', 'schedule');
            if (!$dbc) {
                die ("Can't connect to MySQL:" . mysqli_error($dbc));
            }


           // $sqlfindt ="select * from post where (datetime_from >='$date_from' and datetime_from < '$date_to' and datetime_to >= '$date_to')";
            $sqlfind ="select * from post where (datetime_from <='$date_from' and datetime_to >= '$date_to') or (datetime_from >='$date_from' and datetime_from < '$date_to' and datetime_to >= '$date_to') or (datetime_from <='$date_from' and datetime_to >'$date_from' and datetime_to <= '$date_to') or (datetime_from >='$date_from' and datetime_to <= '$date_to')";
           //var_dump($sqlfindt);
          // die;


            $data = mysqli_query($dbc, $sqlfind);
            $row = mysqli_fetch_assoc($data);

            if ( is_null($row['text'])) {
                $sql = "insert into post(text,datetime_from,datetime_to,status,category,fk_Personid_Person) values('$action','$date_from','$date_to','1','$kind','$uid')";

                if (mysqli_query($dbc, $sql)) {
                    $_SESSION['message'] = "Succesfully added";

                    $_SESSION["date_from"] = null;
                    $_SESSION["date_to"] = null;
                    $_SESSION["action"] = null;
                    $_SESSION["kind"] = null;
                    return redirect('/Day');
                }
            }
            else{
                $_SESSION['error']="at this time post is already written";
            }

            return redirect('/Day');
        }
    }


    public function editaction(request $request)
    {
        $date_from=$request->input('date_from');
        $date_to=$request->input('date_to');
        $action=$request->input('action');
        $kind=$request->input('kind');
        $pid=$request->input('fk');

        $_SESSION["date_from"]=$date_from;
        $_SESSION["date_to"]=$date_to;
        $_SESSION["action"]=$action;
        $_SESSION["kind"]=$kind;


        $_SESSION['error']=null;
        $uid= $_SESSION['userid'];
        $date = strtotime($date_from);
        $date2= strtotime($date_to);
        $time=NOW();
        $timenow=strtotime($time);

        if ( $timenow>=  $date )
        {
            $_SESSION['error']="date is passed";
            return redirect('/Day');
        }
        elseif ($date>=$date2)
        {
            $_SESSION['error']="wrong date";
            return redirect('/Day');
        }
        else {
            $dbc = mysqli_connect('localhost', 'root', '', 'schedule');
            if (!$dbc) {
                die ("Can't connect to MySQL:" . mysqli_error($dbc));
            }


            // $sqlfindt ="select * from post where (datetime_from >='$date_from' and datetime_from < '$date_to' and datetime_to >= '$date_to')";
            $sqlfind ="select count(*) from post where (datetime_from <='$date_from' and datetime_to >= '$date_to') or (datetime_from >='$date_from' and datetime_from < '$date_to' and datetime_to >= '$date_to') or (datetime_from <='$date_from' and datetime_to >'$date_from' and datetime_to <= '$date_to') or (datetime_from >='$date_from' and datetime_to <= '$date_to')";



            $data = mysqli_query($dbc, $sqlfind);
            $row = mysqli_fetch_assoc($data);
           $coun= $row['count(*)'];
           $num=intval($coun);
           $check=1;


            if ( $num<=$check) {

                $sql = "update post set text='$action',datetime_from ='$date_from',datetime_to ='$date_to',category='$kind' where id_Post='$pid'";

                if (mysqli_query($dbc, $sql)) {
                    $_SESSION['message'] = "Succesfully edited";

                    $_SESSION["date_from"] = null;
                    $_SESSION["date_to"] = null;
                    $_SESSION["action"] = null;
                    $_SESSION["kind"] = null;
                    return redirect('/Day');
                }
            }
            else{
                $_SESSION['error']="at this time post is already written";
            }

            return redirect('/Day');
        }

    }
    public function deletepost(request $request)
    {
        $postid=$_GET['id'];
        $dbc = mysqli_connect('localhost', 'root', '', 'schedule');
        if (!$dbc) {
            die ("Can't connect to MySQL:" . mysqli_error($dbc));
        }
        $sql = "DELETE post from post where id_Post='$postid'";
        mysqli_query($dbc, $sql);
        return redirect('/Today');
    }


}
