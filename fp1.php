<?php

if($_SERVER['REQUEST_METHOD']=="POST"){
    session_start();
$email = $_POST['email'];
    
}

?>

<?php
include('3_conn.php');
$sql = "SELECT * FROM user WHERE user.email = $email";
$result = mysqli_query($conn,$sql);

$num = mysqli_num_rows($result);
$pass = $_POST['password'];
$cpass = $_POST['cpassword'];
if($pass == $cpass){

    if($num == 1){
    
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="fp1.php" method="GET">
        Enter new Password<input type="password" name="password">
        confirm Password<input type="password" name="cpassword">
        <button type="submit" name="submit" value="submit">Submit</button>
    </form>
</body>
</html>