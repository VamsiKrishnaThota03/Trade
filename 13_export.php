<?php require "header.php"?>
<?php

    session_start();

    include('3_conn.php');

    $_SESSION['uid'] = $_POST['uid'];
    $_SESSION['utype'] = $_POST['utype'];
    $_SESSION['uname'] = $_POST['uname'];
    $_SESSION['price'] = $_POST['price'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            margin:0;
            padding:0;
            font-family:montserrat;
            height:100vh;  
            overflow:hidden;
        }
        .center{
            position:absolute;
            top:50%;
            /* background-color:cyan; */
            left:50%;
            transform:translate(-50%,-50%);
            width:400px;
            border-radius:10px;
            display:flex;
            /* background-color:cyan; */
        }
        .head{
            margin-top:50px;
            text-align:center;
            padding:0 0 20px 0;
            /* border-bottom: 1px solid silver; */
        }
        .center form{
            padding:0 40px;
            box-sizing:border-box;
        }
        form .txt-field{
            position:relative;
            border-bottom:2px solid #adadad;
            margin:30px 0;
        }
        .txt-field input{
            width:100%;
            padding: 0 5px;
            height:40px;
            font-size:16px;
            border:none;
            background:none;
            outline:none;
        }
        .txt-field label{
            position:absolute;
            top:50%;
            left:5px;
            color:#adadad;
            transform:translateY(-50%);
            font-size:16px;
            pointer-events:none;
            transition:0.5s;
        }
        .part1{
            margin-right:70px;
        }
        .txt-field span::before{
            content:'';
            position:absolute;
            top:40px;
            left:0;
            width:0%;
            height:2px;
            background:#2691d9; 
            transition:0.5s;
        }
        .txt-field input:focus ~ label,.txt-field input:valid ~ label{
            top:-5px;
            color:#2691d9;
        }
        .txt-field input:focus ~ span::before,.txt-field input:valid ~ span::before{
            width:100%;
        }
        .pass{
            margin:-5px 0 20px;
            color:#a6a6a6;
            cursor:pointer;
        }
        .pass:hover{
            text-decoration:underline;
        }
        .center{
            margin-top:20px;
        }
        button{
            margin-top: 350px;
            width:250px;
            height:50px;
            border:1px solid;
            background:#2691d9;
            border-radius:25px;
            font-size:18px;
            color:#e9f4fb;
            font-weight:700;
            cursor:pointer;
            outline:none;
            margin-left:560px;
            margin-bottom: 1000px;
            /* position: relative; */
        }
        button:hover{
            border-color:#2691d9;
            transition:0.5s;    
        }
        .submit12{
            margin-bottom: 1000px;
        }
    </style>
</head>
<body>


    <form action="14_export.php" method="POST">

        <h1 class="head">Enter your details to export</h1>

        <div class="center">
            <div class="part1">
            <div class="txt-field"> <input name="email" type="email" required><label>Email</label></div>

        <div class="txt-field"> <input name="uname" type="text" required><label>Name</label></div>

        <div class="txt-field"> <input name="phone" type="number" required><label>Mobile No</label></div>

        <div class="txt-field"> <input name="city" type="text" required><label>City</label></div>
        </div>
        <div class="part2">
        <div class="txt-field"> <input name="origin_country" type="text" required><label>Origin country</label></div>
        <div class="txt-field"> <input name="dest_country" type="text" required><label>Destination country</label></div>
        <div class="txt-field"> <input name="qty" type="number" required><label>Quantity</label></div>
        </div>
        </div>

        <button type="submit">Submit</button>

    </form>
</body>
</html>