<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostsController extends Controller
{


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
            $dbc = database();


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
            $dbc = database();


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
                    return redirect('/Today');
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
        $date=$request->input('dat');
        $postid=$request->input('fk');
        $dbc = database();

        $sql = "DELETE post from post where id_Post='$postid'";
        mysqli_query($dbc, $sql);
        return redirect("/Todaydisplay?ymd=" . "$date");
    }

    public function poststatus(request $request)
    {
        $poststat=$request->input('poststat');
        $postid=$request->input('fk');
        $date=$request->input('dat');
        $dbc = database();
        $sql="update post set status='$poststat' where id_Post='$postid'";
        if(mysqli_query($dbc, $sql)) {

            return redirect("/Todaydisplay?ymd=" . "$date");
        }
    }


}
