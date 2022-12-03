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

            $pro_cat = "SELECT * FROM productcategories";
            $cat_result = $connect->query($pro_cat);
        }
    ?>

<html>
    <head>
        <title>Edit Product Details</title>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/edit-product-row.css">
    </head>
        <body>
        <?php if (isset($user)): ?>
            <form class="edit-product-containter" action="edit-product-row-process.php" method="post">
                <Table>
                    <tr>
                        <th colspan="2">Edit Product Details</th>
                    </tr>
                    <tr class="head">
                        <td>Product Name</td>
                        <td>Product Code</td>
                    </tr>
                    <tr class="content">
                        <td><input name="pro_name" type="text" value="<?php echo $row['pro_name'];?>"></td>
                        <td class="pro-code-td"><input readonly name="pro_code" type="text" value="<?php echo $row['pro_code'];?>"></td>
                    </tr>

                    <tr class="head">
                        <td>Category</td>
                        <td>Selling Price</td>
                    </tr>
                    <tr>
                        <td>
                            <select name="pro_categories">
                                <option value="<?php echo $row['pro_category']?>"><?php echo $row['pro_category']?></option>
                                <?php 
                                    if($cat_result->num_rows > 0)
                                    {
                                        while ($cat_row = $cat_result->fetch_assoc())
                                        {
                                            if($cat_row['pro_category'] != $row['pro_category'])
                                            {
                                                echo "<option value=".$cat_row['pro_category'].">".$cat_row['pro_category']."</option>";
                                            }
                                        }
                                    }
                                    ?>
                            </select>
                        </td>
                        <td><input name="price" type="number" value="<?php echo $row['price'];?>"></td>
                    </tr>

                    <tr class="head">
                        <td>Measurement</td>
                        <td>Quantity</td>
                    </tr>
                    <tr>
                        <td><input name="meas" type="text" value="<?php echo $row['measurement'];?>"></td>
                        <td><input name="quantity" type="number" value="<?php echo $row['quantity'];?>"></td>
                    </tr>

                    <tr class="btn">
                        <td class="b0"><input class="btn1" type="submit" value="Save" name="save"></td>
                        <td class="b1"><a href="products.php">Cancel</a></td>
                    </tr>
                </Table>
            </form>

        <?php else: ?>
                <div class="no-account-selected">
                    <h1>No account selected</h1>
                    <p class="Login"><a href="index.php">Login</a>
                </div>
        <?php endif; ?>
        </body>
</html>