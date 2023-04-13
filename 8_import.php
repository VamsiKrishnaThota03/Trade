
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>
            body{
                background-color: rgb(243, 250, 250);
            }
            .section {
                width: 1000px;
                background-color: white;
                border-radius: 5px;
                margin-top: 50px;
                /* float: right; */
                padding-top: 2px;
                margin-left: 200px;
                /* margin-right: 70px; */
                border: 1px solid rgba(0, 0, 0, 0.2);
                box-shadow: 0 0 2px rgba(0, 0, 0, 0.2);
            }
            .table th{
                width: 150px;
                /* border:1px solid black; */
                height: 50px;
                font-size: 20px;
                font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            }
            .table td{
                width: 100px;
                text-align: center;
                /* border:1px solid black; */
                height: 50px;
            }
            .btn{
                width: 100px;
                background-color: rgb(68, 68, 153);
                height: 30px;
                color:white;
                border: none;
                border-radius: 5px;
                margin-top: 10px;
                margin-bottom: 20px;
                padding-left: 5px;
                padding-right: 5px;
            }
            .btn:hover{
                font-weight: bold;
                cursor: pointer;
            }
            .heading{
                margin-top: 100px;
                margin-bottom: 30px;
                font-size: 30px;
                font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            }
            .di{
                margin-top: 100px;
            }
        </style>

    </head>
    <body>
        
        <?php
session_start();

include('header.php');
if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn']!=true){
    header("location: Bank_login.php");
    exit();
}

    if(isset($_REQUEST['submit'])){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            include('3_conn.php');
            
            $ptype =  $_POST['ptype'];

            $sql = "Select * from available WHERE available.ptype='$ptype'";
    
            $result1 = mysqli_query($conn,$sql);
           
            $num1 = mysqli_num_rows($result1);
    
            // <th>origin_country</th>
    ?>
            <section class="section">
    <?php
            echo '<table class="heading" Align="center">';
            if($num1 > 0){
                echo '<th>List Of Items</th>';
                echo '</table>';
                echo '<table Align="center" class="table" border="0">
                <tr>
                <th class="a">pid</th>
                <th>ptype</th>
                <th>pname</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Click to select</th>
                </tr>';
                while($row1 = mysqli_fetch_assoc($result1)){
                    echo '<tr >
                    <td class="b">' .$row1['pid'].'</td>
                    <td>' .$row1['ptype']. '</td>
                    <td>' .$row1['pname']. '</td>
                    <td>' .$row1['price']. '</td>
                    <td>' .$row1['qty']. '</td>';
                    echo '<td> <form action="9_import.php" method="POST">
                    <input type="hidden" name="uid" value='.$row1['pid'].'>
                    <input type="hidden" name="utype" value='.$row1['ptype'].'>
                    <input type="hidden" name="uname" value='.$row1['pname'].'>
                    <input type="hidden" name="price" value='.$row1['price'].'>
                    <input type="submit" class="btn" name="submit" value="Click here"></form></td>';
                    '</tr>';
                    // <td><a href="9_import.php?uid=' . $row1['pid'] . '">Click Here</a></td>
                    // <input type="hidden" name="qty" value='.$row1['qty'].'>
                }
                // <td>' .$row1['des_country']. '</td>
                
            }
            else{
                $message = "There are no such ". $ptype ." items available";
                echo '<script language = "Javascript" type="text/javascript">';
                echo 'alert('.json_encode($message) .') ;';
                echo '</script>';
            }
    
        }
    }
    else{
        echo "Click on the submit button";
    }
    
    
    ?>
    </body>
    </html>