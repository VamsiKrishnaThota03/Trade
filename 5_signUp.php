<?php

session_start();

if($_SERVER["REQUEST_METHOD"]=="POST"){
    include('3_conn.php');
    $uname=$_POST['uname'];
    $email=$_POST['email'];
    $uage=$_POST['uage'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $usex = $_POST['usex'];
    $ucity=$_POST['ucity'];
    $country=$_POST['country'];
    $upincode=$_POST['upincode'];
    $uphone=$_POST['uphone'];

    if($cpassword==$password){
            $sql="INSERT INTO user VALUES ('$email', '$uname', '$uage', '$usex','$password','$ucity','$upincode', '$uphone','$country')";

        $result=mysqli_query($conn,$sql);
            
            if($result){
                echo'<script type="text/javascript">alert("Congratulations!! You are registered as Trader. Please Login now to Enter into our website")</script>';
            }
            else{
                $message = "Unable to add new Trader due to" .mysqli_error($conn);
                echo '<script language = "Javascript" type="text/javascript">';
                echo 'alert('.json_encode($message) .') ;';
                echo '</script>';
            }
        }
        else{
            echo'<script type="text/javascript">alert("Password and confirm password does not match")</script>';
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width">
    <title>Sign Up</title>
    <style>
    <?php include './form.css';
    ?>
    </style>
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
            margin-top: 400px;
            width:350px;
            height:50px;
            border:1px solid;
            background:#2691d9;
            border-radius:25px;
            font-size:18px;
            color:#e9f4fb;
            font-weight:700;
            cursor:pointer;
            outline:none;
            margin-left:570px;
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
    <link rel="stylesheet" href="2_style.css">
</head>
<body>
    <div class="main">
        <div class="navbar">
            <div class="logo"><i class="fa fa-globe"></i>Trade</div>
            <div class="menu">
                <ul>
                    <li><a href="1_main_page.php">Home</a></li>
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="4_login.php">Registration</a></li>
                </ul>
            </div>
        </div>
        <form action="5_signUp.php" method="POST">
            <h1 class="head">Sign Up</h1>
        <div class="center">
            
            <div class="part1">
                <div class="txt-field"> <input name="uname" type="text" required><label>Name</label></div>
            <div class="txt-field"> <input name="uage" type="number" required><label>Age</label></div>
            <div style="color:#adadad; padding-left:5px;">Sex <br>
            <div style="display:flex;">
                <div style="margin-top:9px;"><label for="male">Male</label><input name="usex" type="radio" style="margin-left:9px" value="male" id="Male" required></div>
                <div style="margin-top:9px;"><label style="padding-left:2px;" for="female">Female</label><input name="usex" style="margin-left:19px" type="radio" value="female" id="Female"></div>
                <div style="margin-top:9px;"><label style="padding-left:2px;" for="others">Others</label><input name="usx" type="radio" style="margin-left:18px" value="others" id="Others"></div>
            </div>
            </div>
            <div class="txt-field"> <input name="uphone" type="tel" required><label>Mobile No</label></div>
            <div class="txt-field"> <input name="email" type="email" required><label>Email ID</label></div>
            </div>
            <div class="part2">
                <div class="txt-field"> <input name="password" type="password" required><label>Create Password</label></div>
                <div class="txt-field"><input name="cpassword" type="password" required><label>Confirm Password</label></div><br>
                <div class="txt-field"> <input name="ucity" type="text" required><label>City</label></div>
                <div class="txt-field"> <input name="country" type="text" required><label>Country</label></div>
                <div class="txt-field"> <input name="upincode" type="number" required><label>Pincode</label></div>
            </div>
        </div>
        <button type="submit" Align="center">Submit</button>
    </form>
</div>
<?php require "footer.php"?>

</body>

</html>