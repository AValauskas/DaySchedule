<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiaryController extends Controller
{
    public function adddiary(request $request)
    {

        $text=$request->input('text');
        $data = date("Y-m-d");
        $uid= $_SESSION['userid'];

        $sql="insert into diary(text,date,fk_Personid_Person) values('$text','$data','$uid')";
        $dbc = database();
        if(mysqli_query($dbc, $sql))
        {
            $_SESSION['diaryadded']="Diary was succesfully added";
            return redirect('/Diary');
        }

    }

    public function editdiary(request $request)
    {
        $text=$request->input('text');
        $diaryid=$request->input('fk');
        $data = date("Y-m-d");
        $uid= $_SESSION['userid'];
        $dbc = database();
        $sql = "update diary set text='$text' where id_Diary='$diaryid'";
        if(mysqli_query($dbc, $sql))
        {
            $_SESSION['diaryupdated']="Diary was succesfully updated";
            return redirect('/Diary');
        }
    }
    public function deletediaryDay(request $request)
    {
        $diaryid=$_GET['id'];
        $dbc = database();
        $sql = "DELETE diary from diary where id_Diary='$diaryid'";
        if(mysqli_query($dbc, $sql)) {
            $_SESSION['diaryremoved']="Diary was succesfully deleted";
            return redirect('/Diary');

        }
    }
    public function deletediaryJournal(request $request)
    {
        $diaryid=$_GET['id'];
        $dbc = database();
        $sql = "DELETE diary from diary where id_Diary='$diaryid'";
        if(mysqli_query($dbc, $sql)) {
            $_SESSION['diaryremoved']="Diary was succesfully deleted";
            return redirect('/DiaryDisplay');

        }
    }
}
