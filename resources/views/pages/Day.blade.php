@include('pages.Menu')
<!DOCTYPE html>

<html>


<body>

<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <form class="" action="{{URL::to('/addaction')}}" method="get">
            @csrf
            <h3>Add Action</h3><br>
            <div>
                <h2>Date from</h2> <input type="datetime-local" name="date_from" value="<?php  if(isset($_SESSION['date_from'])){echo $_SESSION["date_from"];}  ?>"   required>
                <h2>Date to</h2> <input type="datetime-local" name="date_to" value="<?php if(isset($_SESSION['date_to'])){ echo $_SESSION["date_to"];}  ?>" required>
                <h2>Plan</h2> <input type="text" name="action" value="<?php if(isset($_SESSION['action'])){echo $_SESSION["action"];}  ?>" required/>
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
            <button type=submit name="button">Patvirtinti</button>

        </form>
    </div>
</div>
</body>


</html>