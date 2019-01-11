@include('pages.Menu')

<!DOCTYPE html>

<html>


<body>


<?php

$dbc = mysqli_connect('localhost', 'root', '', 'schedule');
if (!$dbc) {
    die ("Can't connect to MySQL:" . mysqli_error($dbc));
}

$id = $_GET['postid'];
$sql ="select * from post where id_Post='$id'";
$data = mysqli_query($dbc, $sql);
$row = mysqli_fetch_array($data);


$_SESSION["date_from"]=$row['datetime_from'];
$_SESSION["date_to"]=$row['datetime_to'];

$ch=$_SESSION["date_from"];
$ch2=$_SESSION["date_to"];
$_SESSION["date_to"]=$row['datetime_to'];
$_SESSION["action"]=$row['text'];

$datefromtoprint = new DateTime($ch);
$datetotoprint = new DateTime($ch2);

?>

<body>

<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <form class="" action="{{URL::to('/editaction')}}" method="get">
            @csrf
            <h3>Edit Action</h3><br>
            <div>
                <h2>Date from</h2> <input type="datetime-local" name="date_from" value="<?php echo $datefromtoprint->format('Y-m-d\TH:i');?>"   required>
                <h2>Date to</h2> <input type="datetime-local" name="date_to" value="<?php echo $datetotoprint->format('Y-m-d\TH:i');?>" required>
                <h2>Plan</h2> <input type="text" name="action" value="<?php echo $_SESSION["action"];  ?>" required/>
                <br>
                <br><select name="kind">
                    <option value="1">science</option>
                    <option value="2">job</option>
                    <option value="3">sport</option>
                    <option value="4">freetime</option>
                </select >

            </div>
            <br>
            <?php
            if(isset($_SESSION['error']))
            {
                $wrong=$_SESSION['error'];
                echo "$wrong";
                $_SESSION['error']=null;
            }


            if (isset($_SESSION['message']))
            {
                $success=$_SESSION['message'];
                echo "$success";
                $_SESSION['message']=null;

            }
            ?>
            <br>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="fk" value="{{$id}}">
            <button type=submit name="button">Patvirtinti</button>

        </form>
    </div>
</div>

<form class="" action="{{URL::to('/deletepost')}}" method="get">
    @csrf

    <input type="hidden" name="fk" value="{{$id}}">
    <input type="hidden" name="dat" value="{{ $datefromtoprint->format('Y-m-d')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <button type=submit name="button">Delete</button>
</form>

<form class="" action="{{URL::to('/poststatus')}}" method="get">
    @csrf
    <select  name="poststat" onchange="this.form.submit()">
        <option value="no"  disabled selected>status</option>
        <option value="2">done</option>
        <option value="4">failed</option>
    </select>
    <input type="hidden" name="fk" value="{{$id}}">
    <input type="hidden" name="dat" value="{{ $datefromtoprint->format('Y-m-d')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
</form>

</body>


</body>




</html>