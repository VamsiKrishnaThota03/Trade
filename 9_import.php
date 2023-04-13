<?php require('header.php')?>
<?php
    session_start();
    include('3_conn.php');
    $_SESSION['uid'] = $_POST['uid'];
    $_SESSION['utype'] = $_POST['utype'];
    $_SESSION['uname'] = $_POST['uname'];
    $_SESSION['price'] = $_POST['price'];
    // $_SESSION['qty'] = $_POST['qty'];

    // $sql = "UPDATE available SET qty = qty - ".$_SESSION['qty']." WHERE available.pid = ".$_SESSION['uid']."";
    // $result = mysqli_query($conn,$sql);

    // if($result){
    //     echo "Updated successfully";
    // }
    // else{
    //     echo "Cannot be Updated ". mysqli_error($conn);
    // }
    // $_SESSION['qty'] = $_POST['qty'];

    // echo $_SESSION['uid'];
    // $uid = $_POST['uid'];
    // $uname = $_POST['uname'];
    // $utype = $_POST['utype'];
    // $price = $_POST['price'];
    // $qty = $_POST['qty'];
    // $mail = $_GET['mail'];

    // echo $uid;
    // echo $utype;
    // echo $uname;
    // echo $price;
    // echo $qty;
    // echo $mail;
?>

<?php
    // if($_SERVER["REQUEST_METHOD"] == "POST"){
    //     include('3_conn.php');
    //     $email = $_POST['email'];
    //     $sql = "SELECT * FROM available WHERE available.pid = $uid";
    
    //     $result1 = mysqli_query($conn,$sql);
    
    //     $num1 = mysqli_num_rows($result1);

    // // <th>origin_country</th>

    //     if($num1 > 0){
    //         echo '<table border="1">
    //         <tr>
    //         <th colspan="7">List Of Items</th></tr>
    //         <th>pid</th>
    //         <th>ptype</th>
    //         <th>pname</th>
    //         <th>Price</th>
    //         <th>Quantity</th>
    //         </tr>';
    //         while($row1 = mysqli_fetch_assoc($result1)){
    //             echo '<tr>
    //             <td>' .$row1['pid'].'</td>
    //             <td>' .$row1['ptype']. '</td>
    //             <td>' .$row1['pname']. '</td>
    //             <td>' .$row1['price']. '</td>
    //             <td>' .$row1['qty']. '</td>
    //             </tr>';
    //             // <th>Click to select</th>
    //             // echo '<td> <form action="" method="POST"><input type="hidden" name="id" value=' .$row['id'] . '><input type="submit" name="submit" value="Delete"></form></td>';
    //             // <td><a href="9_import.php?uid=' . $row1['pid'] . ' ">Click Here</a></td>
    //         }
    //         // <td>' .$row1['des_country']. '</td>
    //     }
    // }

?>


<?php
    // if($_SERVER["REQUEST_METHOD"] == "POST"){
    //     session_start();
    //     include('conn.php');

    //     $pid = $_POST['pid'];
    //     $email = $_POST['email'];
    //     $uname = $_POST['uname'];
    //     $phone = $_POST['phone'];
    //     $city = $_POST['city'];
    //     $dest_country = $_POST['dest_country'];
    //     $qty = $_POST['qty'];

    //     $sql2 = "UPDATE 'available' SET 'qty' = 'qty' - '{$qty}' WHERE available.pid = pid";
    //     $result1 = mysqli_query($conn,$sql2);

    //     $sql = "Select available.email,available.pid,avaialble.ptype,available.pname,available.country,available.price from available where available.pid = '$pid'";

    //     $sql3 = "INSERT INTO 'import_table' VALUES ('$email','$pid','$dest_country','$qty','')";

    //     $result = mysqli_query($conn,$sql);
    
    //     echo '<table border="1">
    //     <tr>
    //         <th colspan="9">Item you Selected</th></tr>
    //         <th>User Name</th>
    //         <th>Mobile Number</th>
    //         <th>City</th>
    //         <th>Country</th>
    //         <th>pid</th>
    //         <th>ptype</th>
    //         <th>pname</th>
    //         <th>Destination country</th>
    //         <th>Price</th>
    //     </tr>';

    //     while($res = mysqli_fetch_assoc($result)){
    //         echo '<tr>
    //         <td>' .$phone.'</td>
    //         <td>' .$city.'</td>
    //         <td>' .$country .'</td>
    //         <td>' .$uname. '</td>
    //         <td>' .$res['pid'].'</td>
    //         <td>' .$res['ptype'].'</td>
    //         <td>' .$res['pname'].'</td>
    //         <td>' .$res['country'].'</td>
    //         <td>' .$res['price'].'</td>
    //         </tr>';
    //     }
    //     // echo "Your item will be delivered within 10-15 days";
    // }

?>
        
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imports2</title>
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
</head>
<body>


    <form action="11_import.php" method="POST">
        <!-- <div>
            
            <h2>Enter your Email address to receive updates</h2>
            Email:<input type="email" name="email">

            <h2>Enter your name</h2>
            Name: <input type="text" name="uname">

            <h2>Enter you mobile number to contact</h2>
            Mobile Number: <input type="number" name="phone">

            <h2>Enter your city where the item has to be imported</h2>
            City: <input type="text" name="city">

            <h2>Enter the country where the item has to be picked</h2>
            Origin Country: <input type="text" name="origin_country">

            <h2>Enter your country where the item has to be imported</h2>
            Destiny Country: <input type="text" name="dest_country">
            
            <h2>Enter the number of quantity in tons that you want to import:</h2>
            Qantity: <input type="number" name="qty">
            
            <button type="submit" name="submit">Submit</button>
        </div> -->
        <!-- <section class="sec"> -->
        <h1 class="head">Details</h1>
        <div class="center">
            
            <div class="part1">
                <div class="txt-field"> <input name="email" type="email"  required><label>Email</label></div>
                <div class="txt-field"> <input type="text" name="uname" required><label>Name</label></div>
                <div class="txt-field"> <input type="number" name="phone" required><label>Mobile No</label></div>

            <div class="txt-field"> <input type="text" name="city" required><label>City</label></div>
            
        </div>
        <div class="part2">
        <div class="txt-field"> <input type="text" name="origin_country" required><label>Origin Country</label></div>
            <div class="txt-field"> <input type="text" name="dest_country" required><label>Destination Country</label></div>
            <div class="txt-field"> <input type="number" name="qty" required><label>Quantity</label></div>
            </div>
        </div>
        <button type="submit" Align="center" name="submit">Submit</button>
        <!-- </section> -->
    </form>
</div>
    </form>
    <?php require "footer.php"?>


</body>
</html>

