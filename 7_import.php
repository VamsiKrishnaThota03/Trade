<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .item{
            margin-left:400px;
            margin-top:180px;
        }
        .item h2{
            font-size:30px;
            font-family:Arial, Helvetica, sans-serif;
        }
        .content{
            margin-top:30px;
            margin-left:120px;
        }
        .content button{
            width: 100px;
            background-color: rgb(68, 68, 153);
            height: 30px;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
            color:white;
            margin-bottom: 20px;
            padding-left: 5px;
            padding-right: 5px;
        }
        .content input{
            height:30px;
        }
    </style>
</head>
<body>
<?php require "header.php"?>

    <form action="8_import.php" method="POST">
        
        <div class="item"><h2>Enter the item that you want to Import</h2>
            <div class="content">
                <input name="ptype" type="text" required >

            <!-- <h2>Enter the product id from the below table</h2>
            Product Id<input type="number" name="pid"> -->
            <!-- <h2>Enter your Email address to receive updates</h2>
            Email:<input type="text" name="email"> -->
            <!-- <h2>Enter your name</h2>
            Name: <input type="text" name="uname">
            <h2>Enter you mobile number to contact</h2>
            Mobile Number: <input type="number" name="phone">
            <h2>Enter your city where the item has to be imported</h2>
            City: <input type="text" name="city">
            <h2>Enter your country where the item has to be imported</h2>
            Country: <input type="text" name="dest_country">
            <h2>Enter the number of quantity in tons that you want to import:</h2>
            Qantity: <input type="number" name="qty"> -->
            <!-- <button type="submit" name="submit">Submit</button> -->
            <button type="submit" name="submit">Submit</button>
            </div>
        </div>
    </form>
    <?php require "footer1.php"?>

</body>
</html>