<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="2_style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trade</title>
    <style>
        body{
            background-color:white;
        }
        .pic1, .pic2, .pic3{
            margin-top:30px;
            margin-right:15px;
        }
        .img1, .img2, .img3{
            height:250px;
            width:400px;
        }
        .images{
            display:flex;
        }
        .import a, .add a{
            text-decoration:none;
            color:black;
            font-family:Arial;
            font-size:20px;
        }
        .export a{
            text-decoration:none;
            color:black;
            font-size:20px;
            font-family:Arial;
        }
        .import a:hover, .export a:hover, .add a:hover{
            font-weight:bold;   
        }
        .content{
            display:flex;
        }
        .add{
            margin-top:60px;
        }
    </style>
</head>
<body>
    <?php require "header.php"?>
    <?php
    if(isset($_SESSION['MloggedIn'])){
        if( $_SESSION['MloggedIn']==true){
            $message = "Welcome ". $_SESSION['uname']." to the Trading Website";
            echo '<script language = "Javascript" type="text/javascript">';
            echo 'alert('.json_encode($message) .') ;';
            echo '</script>';
        }
    } 
    ?>
    
        <div class="content">
            <div class="import">
            <a href="7_import.php">Import</a>
        </div>
        <div class="export">
            <a href="12_export.php">Export</a>
        </div>
        <div class="add">
            <a href="10_add_items.php">Add Items</a>
        </div>
        </div>
        <div class="images">
            <div class="pic1">
            <img src="linechart1.png" alt="" class="img1">
        </div>
        <div class="pic2">
            <img src="linechart2.png" alt="" class="img2">
        </div>
        <div class="pic3">
            <img src="chart3.png" alt="" class="img3">
        </div>
        </div>
        
</body>
</html>