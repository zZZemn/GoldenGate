<?php
    session_start();
    include "database.php";

    if(isset($_SESSION["user_id"]))
        {
            $sql = "SELECT * FROM user
            WHERE user_no = {$_SESSION["user_id"]}";
            $result = $connect->query($sql);
            $user = $result->fetch_assoc();

            $pro_code = $_GET['pro_code'];

            $query = "SELECT * FROM products WHERE pro_code = $pro_code";
            $result = $connect->query($query);
            $row = $result->fetch_assoc();
        }
    ?>

<html>
    <head>
        <title>Edit Product Details<?php echo " ".$row['invent_no'];?></title>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/edit-product-row.css">
    </head>
        <body>
        <?php if (isset($user)): ?>
            <h1>hi</h1>
        <?php else: ?>
                <div class="no-account-selected">
                    <h1>No account selected</h1>
                    <p class="Login"><a href="index.php">Login</a>
                </div>
        <?php endif; ?>
        </body>
</html>