<!DOCTYPE html>
<html lang="en">
<!-- <script src="https://use.fontawesome.com/cf867411c8.js"></script> -->
<head>
    <style>
        .navbar {
        background-color: rgb(35, 35, 82);
        height: 60px;
        margin-bottom: 10px;
        }

        .logo {
            color: bisque;
            float: left;
            font-size: 30px;
            padding-top: 10px;
            padding-left: 20px;
            padding-right: 40px;
        }

        .menu ul {
            float: left;
            display: flex;
            margin-top: 20px;
        }

        .menu ul li {
            list-style-type: none;
            margin-left: 70px;
        }

        .menu ul li a {
            font-family: Arial;
            color: white;
            text-decoration: none;
        }

        .menu ul li a:hover {
            font-weight: bold;
        }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="navbar">
    <div class="logo"><i class="fa fa-globe"></i>Trade</div>
        <div class="menu">
            <ul>
                <li><a href="21_main.php">Home</a></li>
                <li><a href="#">Dashboard</a></li>
                <li><a href="10_add_items.php">Add items</a></li>
                <li><a href="#">About</a></li>
                <li><a href="11_logOut.php">Log Out</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
