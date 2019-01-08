<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EvaluateController extends Controller
{
    //

    public function evaluate(request $request)
    {
        $rate=$request->input('evaluation');
        $date=$request->input('dat');
        $uid= $_SESSION['userid'];
        $estimate=intval($rate);

        $dbc = mysqli_connect('localhost', 'root', '', 'schedule');
        if (!$dbc) {
            die ("Can't connect to MySQL:" . mysqli_error($dbc));
        }
        $sql="select * from rate where date='$date'";
        $data = mysqli_query($dbc, $sql);
        $row = mysqli_fetch_assoc($data);

        if ( is_null($row['date'])) {
            $sql2="insert into rate(date,value,fk_Personid_Person) values('$date','$estimate','$uid')";
            $_SESSION['evaluate']="Diary was succesfully added";
        } else
        {
            $sql2="update rate set value='$rate' where date='$date'";
            $_SESSION['evaluate']="Diary was succesfully updated";
        }
        if(mysqli_query($dbc, $sql2))
        {

            return redirect("/Todaydisplay?ymd=" . "$date");
        }


    }

}
