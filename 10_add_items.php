<?php require('header.php')?>
<?php
    global $pid;
    if($_SERVER['REQUEST_METHOD']=='POST'){
        
        include('3_conn.php');
        $email = $_POST['email'];
        $ptype = $_POST['ptype'];
        $pname = $_POST['pname'];
        $country = $_POST['country'];
        $qty = $_POST['qty'];
        $price = $_POST['price'];
        
        $sql = "INSERT INTO available VALUES ('$email','$pid','$ptype','$pname','$country','$qty','$price')";
        
        $result = mysqli_query($conn,$sql);
        if(isset($result)){
            $message = "Your product succesfully added to our website";
            echo '<script language = "Javascript" type="text/javascript">';
            echo 'alert('.json_encode($message) .') ;';
            echo '</script>';
        }
        else{
            echo "Your item cannot be added";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
       body{
            background-color: rgb(243, 250, 250);
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
            left:40%;
            transform:translate(-50%,-50%);
            width:400px;
            border-radius:10px;
            display:flex;
            /* background-color:cyan; */
        }
        .head{
            margin-left:175px;
            margin-top:40px;
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
            margin:25px 0;
            width: 150%;
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
        .center{
            margin-top:20px;
        }
        button{
            width:250px;
            height:50px;
            border:1px solid;
            background:#2691d9;
            border-radius:25px;
            font-size:18px;
            color:#e9f4fb;
            font-weight:700;
            margin-left:150px;
            cursor:pointer;
            outline:none;
        }
        button:hover{
            border-color:#2691d9;
            transition:0.5s;    
        }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="center">
        <form action="10_add_items.php" method="POST">
            <h1 class="head">Add Items</h1>
            <div class="part1">
                <div class="txt-field"> <input name="email" type="email"  required><span></span><label>Email</label></div>
                
                <div class="txt-field"> <input type="text" name="ptype" required><label>Product type</label></div>
                <div class="txt-field"> <input type="text" name="pname" required><label>Product Name</label></div>
                <div class="txt-field"> <input type="text" name="country" required><label>Country</label></div>
                <div class="txt-field"> <input type="number" name="qty" required><label>Quantity</label></div>

            <div class="txt-field"> <input type="text" name="price" required><label>Price</label></div>
            
            <button type="submit">Add Item</button>
        </div>
</form>
</body>
</html>