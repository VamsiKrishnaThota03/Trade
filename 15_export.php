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
                margin:0;
                padding:0;
            }
            .section {
                width: 1000px;
                background-color: white;
                border-radius: 5px;
                margin-top: 50px;
                padding-top: -10px;
                padding-bottom:70px;
                margin-left: 200px;
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

if($_SERVER["REQUEST_METHOD"]=="POST"){
    session_start();
    include('3_conn.php');
    $ptype = $_POST['ptype'];
    $pname = $_POST['pname'];
    // $destiny_country = $_POST['destiny_country'];

    $sql = "SELECT available.pid,available.ptype,available.pname,available.price,available.qty from available where available.ptype = '$ptype' and available.pname='$pname'";

    $result2 = mysqli_query($conn,$sql);

    // $result = mysqli_fetch_assoc($res);

    $num4 = mysqli_num_rows($result2);
?>
            <section class="section">
    <?php
    echo '<table class="heading" Align="center">';
    if($num4 > 0){
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
            // <tr>
            // <th colspan="6">List Of Items</th></tr>
            // <th>pid</th>
            // <th>ptype</th>
            // <th>pname</th>
            // <th>Price</th>
            // <th>Quantity</th>
            // <th>Click to select</th>
            // </tr>';
            // $nu = 1;
        while($row2 = mysqli_fetch_assoc($result2)){
            echo '<tr>
            <td class="b">'.$row2['pid'].'</td>
            <td>'.$row2['ptype'].'</td>
            <td>'.$row2['pname'].'</td>
            <td>'.$row2['price'].'</td>
            <td>'.$row2['qty'].'</td>';
            echo '<td> <form action="13_export.php" method="POST">
                    <input type="hidden" name="uid" value='.$row2['pid'].'>
                    <input type="hidden" name="utype" value='.$row2['ptype'].'>
                    <input type="hidden" name="uname" value='.$row2['pname'].'>
                    <input type="hidden" name="price" value='.$row2['price'].'>
                    <input type="submit" class="btn" name="submit" value="Click here"></form></td>';
            '</tr>';
            // $nu = $nu + 1;
        }
    }
    else{
        $message = "There are no ". $ptype." with item name ". $pname ." available right now";
            echo '<script language = "Javascript" type="text/javascript">';
            echo 'alert('.json_encode($message) .') ;';
            echo '</script>';
            // header("location: 15_export.php");
        
    }
}

?>
</body>
</html>