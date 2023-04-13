<?php

$Mlogin=false;
$loggedIn=false;
$showError=false;


    if($_SERVER["REQUEST_METHOD"]=="POST"){
        include ('3_conn.php');

        $uname = $_POST["uname"];
        $_SESSION['uname'] = $_POST['uname'];
        $password = $_POST["password"];
        $sql = "Select * from user where uname='$uname' AND password='$password'";

        $result = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);

        if($num == 1){
            $Mlogin=true;
            session_start();
            $_SESSION['MloggedIn']=true;
            $_SESSION['loggedIn']=true;
            $_SESSION['uname']=$row['uname'];
            $_SESSION['password']=$row['password'];
            header("location: 6_trade.php");
        }
        else{
            $showError = "Invalid credentials, signUp to register";
            // header("location: 5_signUp.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body{
            margin:0;
            padding:0;
            font-family:montserrat;
            height:100vh;  
            overflow:hidden;
            background-image: url("login_bg.jpeg");
            background-repeat: no-repeat;
            background-size: cover;

        }
        .navbar2{
            background-color: rgb(35, 35, 82);
            height: 60px;
            margin-bottom: 100px;
        }
        .s{
            /* margin-top: 50px; */
            float: right;
        }
        .center{
            position:absolute;
            top:50%;
            left:50%;
            transform:translate(-50%,-50%);
            width:400px;
            border-radius:10px;
            /* background-color:cyan; */
        }
        .center h1{
            margin-top: 70px;
            text-align:center;
            padding:0 0 20px 0;
            border-bottom: 1px solid silver;
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
            margin:-5px 0 20px 5px;
            color:#a6a6a6;
            cursor:pointer;
        }
        .pass:hover{
            text-decoration:underline;
        }
        button{
            width:100%;
            height:50px;
            border:1px solid;
            background:#2691d9;
            border-radius:25px;
            font-size:18px;
            color:#e9f4fb;
            font-weight:700;
            cursor:pointer;
            outline:none;
        }
        button:hover{
            border-color:#2691d9;
            transition:0.5s;    
        }
        .signup{
            margin:30px 0;
            text-align:center;
            font-size:16px;
            color:#666666;
        }
        .signup a{
            color:#2691d9;
            text-decoration:none;
        }
        .signup a:hover{
            text-decoration:underline;
        }
        .center{
            background-color: white;
            opacity: 0.9;
            height: 600px;
            margin-top: 100px;
            margin-bottom: 100px;
        }
    </style>
    <link rel="stylesheet" href="2_style.css">
</head>
<body>
    <div class="main">
        <div class="navbar2">
            <div class="logo"><i class="fa fa-globe"></i>Trade</div>
            <div class="menu">
                <ul>
                    <li><a href="1_main_page.php">Home</a></li>
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="4_login.php">Add items</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="4_login.php">Registration</a></li>
                </ul>
            </div>
        </div>
        <?php
            if($showError){
                echo'<script type="text/javascript">alert("ERROR !! Invalid credentials, Sign Up to Register")</script>';
            }
            if($Mlogin){
                echo'<script type="text/javascript">alert("Logged In succesfully!")</script>';
            }
        ?>
        <section class="s">
        <div class="login">
            <div class="center">
            <form action="4_login.php" method="POST">
                <h1>Login</h1>
            <div class="txt-field"><input name="uname" type="text" required>
            <span></span>
            <label>Username</label>
            </div><br>
            <div class="txt-field"><input name="password" type="password" required>
            <span></span><label>Password</label></div><br>

            <!-- <div class="pass"><a href="fp.php">Forgot Password?</a></div> -->

            <div><button type="submit" value="Login">Login</button></div>
            <br>
            <div class="signup">Not a member? <a href="5_signUp.php">Signup</a></div>
        </div>
        </form>
        </div>
    
    </section>
        
        
    </div>



</body>
</html>