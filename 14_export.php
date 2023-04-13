<?php require "header.php"?>

<?php
    session_start();

    include('3_conn.php');
    // $pid = " . $_SESSION['uid'] . ";
    // $sql = "SELECT available.pid,available.ptype,available.pname,available.origin_country,available.price WHERE available.pid = {" . $_SESSION['uid'] . "};

    $qty = $_POST['qty'];
    $sql1 = "UPDATE available SET qty = qty - $qty WHERE available.pid = ".$_SESSION['uid']."";
    $result1 = mysqli_query($conn,$sql1);
    if($result1){
        echo "Updated successfully";
    }
    else{
        echo "Cannot be Updated ". mysqli_error($conn);
    }

    $sql = "INSERT INTO `export_data` VALUES
    ('".$_POST['email']."','".$_POST['uname']."',".$_POST['phone'].",'".$_POST['city']."','".$_POST['origin_country']."',".$_SESSION['uid'].",'".$_SESSION['utype']."','".$_SESSION['uname']."','".$_POST['dest_country']."','".$_SESSION['price']."')";

    // echo $sql;
    echo "<br><br>";
    $result = mysqli_query($conn,$sql);

    if($result){
        $message = "Your item will be picked by an mediater within 3 days";
            echo '<script language = "Javascript" type="text/javascript">';
            echo 'alert('.json_encode($message) .') ;';
            echo '</script>';
    }
    else{
        echo "Connot be inserted ". mysqli_error($conn);
    }

    $sql2 = "INSERT INTO `total_table` VALUES('".$_POST['email']."','".$_POST['uname']."',".$_SESSION['uid'].",'".$_SESSION['utype']."','".$_SESSION['uname']."','export','".$_SESSION['price']."')";
    $result3 = mysqli_query($conn,$sql2);
    
?>

<?php require "footer.php"?>
