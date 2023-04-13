<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            margin:0;
            padding:0;
            background-color: rgb(243, 250, 250);
        }
        .click{
            font-family:Arial;
            font-weight:10;
            font-size:20px;
            padding-left:20px;
        }
        .item{
            display:flex;
        }
        .input1{
            height:15px;
            /* margin-top: */
        }
        button{
            margin-top:20px;
            margin-left:600px;
            width:130px;
            height:40px;
            background-color: rgb(68, 68, 153);
            border:none;
            border-radius:5px;
            color:white;
        }
        .table1{
            margin-top:150px;
        }
        h2{
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            font-weight:50;
        }
    </style>
</head>
<body>
<?php require "header.php"?>

    <form action="15_export.php" method="POST">

        <h2 class="click">Click <a href="10_add_items.php">here</a> to add any items in the website</h2>
        
        <table Align="center" class="table1">
            <tr>
                <td><h2>Enter the type of the item that you want to Export:</h2></td>
                <td><input class="input1" type="text" name="ptype"></td>
            </tr>
        </table>
        <table Align="center">
            <tr>
                <td><h2>Enter the name of the item that you want to Export:</h2></td>
                <td><input type="text" name="pname"></td>

            </tr>
        </table>
            
        <button type="submit">submit</button>

    </form>
</body>
</html>