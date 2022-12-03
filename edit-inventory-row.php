<?php
    session_start();
    include "database.php";

    if(isset($_SESSION["user_id"]))
        {
            $sql = "SELECT * FROM user
            WHERE user_no = {$_SESSION["user_id"]}";
            $result = $connect->query($sql);
            $user = $result->fetch_assoc();

            $invent_no = $_GET['invent_no'];

            $query = "SELECT * FROM inventory WHERE invent_no = $invent_no";
            $result = $connect->query($query);
            $row = $result->fetch_assoc();

            $pro_code =  $row['pro_code'];
            $prod_query = "SELECT * FROM products WHERE pro_code = $pro_code";
            $prod_query_result = $connect->query($prod_query);
            $prod_row = $prod_query_result->fetch_assoc();
        }
    ?>

<html>
    <head>
        <title>Edit Inventory ID<?php echo " ".$row['invent_no'];?></title>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/edit-inventory-row.css">
    </head>
        <body>
        <?php if (isset($user)): ?>
            <div class="inventory-edit-container">
                <a href="inventory.php"><img src="img/close-circle.svg" alt=""></a>
                <form action="edit-inventory-row-process.php" method="post">
                <table class="inventory-edit-table-container">
                    <tr class="heading">
                        <th>Edit Inventory Row</th>
                        <td><input readonly name="invent_id" type="text" value="<?php echo $row['invent_no']?>"></td>
                    </tr>
                    
                    <tr class="pro_code_name">
                        <td><?php echo $prod_row['pro_name']?></td>
                        <td class="pro_code"><?php echo $row['pro_code']?></td>
                    </tr>

                        <tr class="head">
                            <td>Capital</td>
                            <td>Delivered Quantity</td>
                        </tr>
                        
                        <tr>
                            <td><input name="del_price" type="text" value="<?php echo $row['del_price'];?>"></td>
                            <td><input name="del_qty" type="text" value="<?php echo $row['del_qty'];?>"></td>
                        </tr>
                        
                        <tr class="head">
                            <td>Delivery Date</td>
                            <td>Expiration Date</td>
                        </tr>
                        
                        <tr>
                            <td><input name="del_date" type="date" value="<?php echo $row['del_date'];?>"></td>
                            <td><input name="ex_date" type="date" value="<?php echo $row['ex_date'];?>"></td>
                        </tr>
                        
                        <tr class="save-btn">
                            <td colspan="2"><input type="submit" value="Save Changes" name="save"></td>
                        </tr>
                    </form>
                </table>
            </div>
            </body>
        <?php else: ?>
            <div class="no-account-selected">
                <h1>No account selected</h1>
                <p class="Login"><a href="index.php">Login</a>
            </div>
        <?php endif; ?>
</html>

