<?php
include('02_conn.php');

if(isset($_REQUEST['update'])){
    if($_REQUEST['name'] == "" || $_REQUEST['roll'] == "" || $_REQUEST['address'] == ""){
        echo "Fill all the values";
    }
    else{
        $name = $_REQUEST['name'];
        $roll = $_REQUEST['roll'];
        $address = $_REQUEST['address'];
        $sql = "UPDATE student SET name = '$name', roll = '$roll', $address = '$address' WHERE id = {$_REQUEST['id']}";

        if(mysqli_query($conn,$sql)){
            echo "Edited successfully";
        }
        else{
            echo "Cannot be Edited".mysqli_error($conn);
        }
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
    <?php
        if(isset($_REQUEST['edit'])){
            $sql = "SELECT * FROM student WHERE id = {$_REQUEST['id']}";
            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($result);
        }
    ?>
        <form action="" method="POST">
            <div>
            <label for="name">Name</label>
            <!-- <input type="text" name="name"> -->
            <input type="text" name="name" id="name" value="
            <?php 
                if(isset($row["name"])){
                    echo $row['name'];
                }
            ?>">
            </div>

            <div>
            <label for="roll">Roll</label>
            <!-- <input type="text" name="name"> -->
            <input type="text" name="roll" id="roll" value="
            <?php 
                if(isset($row["roll"])){
                    echo $row['roll'];
                }
            ?>">
            </div>

            <div>
            <label for="address">Address</label>
            <!-- <input type="text" name="address"> -->
            <input type="text" name="address" id="address" value="
            <?php 
                if(isset($row["address"])){
                    echo $row['address'];
                }
            ?>">
            </div>

            <input type="hidden" name="id" value="
            <?php
                echo $row['id'];
            ?>
            ">
            <button type="submit" name="update">Update</button>

        </form>

            <div>
                
            <?php
            session_start();

            $sql = "SELECT * FROM avaialable WHERE available.email = ".$_SESSION['email']."";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result) > 0){
                echo '<table class="table" border="1">
                    <thead>
                    <tr>
                        <th>ID</th> 
                        <th>Name</th> 
                        <th>Roll</th> 
                        <th>Address</th> 
                        <th>action</th>
                    </tr>
                    </thead>';
                    
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<tr>';
                        echo '<td>' . $row['id'] .'</td>';
                        echo '<td>' . $row['name'] .'</td>';
                        echo '<td>' . $row['roll'] .'</td>';
                        echo '<td>' . $row['address'] .'</td>';

                        
                        echo '<td> <form action="" method="POST"><input type="hidden" name="id" value=' .$row['id'] . '><input type="submit" name="edit" value="Edit"></form></td>';
                        echo '</tr>';
                    }
                    echo '</table>';
            }
            else{
                echo " no results";
            }
        ?>
            </div>

        
</body>
</html>