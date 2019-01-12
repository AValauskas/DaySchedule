<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
        .sideBody{
            background: #7c7c7c;
        }
        .sideMenu{
            width: 100%;
            margin: 0;
            padding: 0;
        }
        .btn#side{
            background: transparent;
            font-size: 300%;
            color: black;
            width: 100%;
            height: 75px;
        }
        .btn#side:hover{
            color: white;
            background: #2d2d2d;
        }
        .row{
            margin-right: 0px;
            margin-left: 0px;
        }
    </style>
</head>

<body class="sideBody">
<div class="sideMenu">
    <div class="row">
        <a href=../public/registration><input type=button class="btn btn-lg" id="side" value='HOME'></a>
    </div>
    <div class="row">
        <a href=../public/registration><input type=button class="btn btn-lg" id="side" value='SCHEDULE'></a>
    </div>
    <div class="row">
        <a href=../public/registration><input type=button class="btn btn-lg" id="side" value='POSTS'></a>
    </div>
    <div class="row">
        <a href=../public/registration><input type=button class="btn btn-lg" id="side" value='JOURNAL'></a>
    </div>
    <div class="row">
        <a href=../public/registration><input type=button class="btn btn-lg" id="side" value='STATISTICS'></a>
    </div>
</div>
</body>
</html>