@include('pages.Menu')
        <!DOCTYPE html>

<html>


<body>

<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <form class="" action="{{URL::to('/adddiary')}}" method="get">
            @csrf
            <h3>Add Action</h3><br>
            <div>
                <h2>Diary</h2> <textarea type="text" name="text" rows="4" cols="50" value=""></textarea>
            </div>
            <br>
            <br>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <button type=submit name="button">Patvirtinti</button>

        </form>
    </div>
</div>
</body>


</html>