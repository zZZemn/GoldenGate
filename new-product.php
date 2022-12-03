<?php 
include("time&date.php");
session_start();

if (isset($_SESSION["user_id"])) {
    include("database.php");

    $sql = "SELECT * FROM user
            WHERE user_no = {$_SESSION["user_id"]}";
    $result = $connect->query($sql);
    $user = $result->fetch_assoc();

    if(isset($_POST['save']))
    {
        
        $pro_code = $_POST['pro_code'];
        $pro_name = $_POST['pro_name'];
        $pro_cat = $_POST['pro_categories'];
        $pro_measurement = $_POST['pro_measurement'];
        $selling_price = $_POST['pro_selling_price'];

        $del_price = $_POST['del_price'];
        $quantity = $_POST['del_quan'];
        $ex_date = $_POST['ex_date'];
        $del_date = $_POST['del_date'];

        $insertToTBLInventory = "INSERT INTO inventory (`del_price`, `del_qty`, `ex_date`, `del_date`, `pro_code`) 
                                VALUES ('$del_price','$quantity','$ex_date','$del_date', '$pro_code')";

        $insertToTBLProducts = "INSERT INTO products(`pro_name`, `pro_code`, `pro_category`, `measurement`, `price`, `quantity`) 
                                VALUES ('$pro_name','$pro_code','$pro_cat','$pro_measurement','$selling_price','$quantity')";

        $insertingToProducts = $connect->query($insertToTBLProducts);
        $insertingToInventory = $connect->query($insertToTBLInventory);

        if($insertingToProducts == true && $insertToTBLInventory == true)
            {
              header("location: products.php");
            }
        else
            {
                echo "invalid";
            }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory Maintenance</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/new-product.css">
</head>
<body>
    <?php if (isset($user)): ?>
        <nav class="top-nav">
            <a href="goldengate.php"><img src="img/ggd-logo.png" alt="GGD"></a>
            <h1>ADD NEW PRODUCT</h1>
            <h5><?php echo $time ?></h5>
        </nav>
    
        <nav class="side-nav">
            <table class="nav-links">
                <tr class="user-profile">
                    <td><img src="img/person-circle-outline.svg" alt=""></td>
                    <td><a class="profile" href="#"><?php echo $user["f_name"]." ".$user["mi"]." ".$user["l_name"] ?></a></td>
                </tr>
                <tr>
                    <td><img src="img/reader-outline.svg" alt=""></td>
                    <td><a class="sales-trans" href="#">SALES TRANSACTION</a></td>
                </tr>
                <tr>
                    <td><img src="img/layers-outline.svg" alt=""></td>
                    <td><a class="inventory" href="inventory.php">INVENTORY</a></td>
                </tr>
                <tr>
                    <td><img src="img/stats-chart-outline.svg" alt=""></td>
                    <td><a class="reports" href="#">REPORTS</a></td>
                </tr>
                <tr>
                    <td><img src="img/build-outline.svg" alt=""></td>
                    <td><a class="maintenance" href="#">MAINTENANCE</a></td>
                </tr>
                <tr class="others-td">
                    <td><img src="img/apps-outline.svg" alt=""></td>
                    <td><a class="others" href="#">OTHERS</a></td>
                </tr>
            </table>

            <div class="date"><?php echo "<h4>$date</h4>"; ?></div>

            <table class="daily-sales">
                <tr>
                    <td class="img-td"><img src="img/wallet-outline.svg" alt=""></td>
                    <td class="daily-sales-text-td">DAILY SALES</td>
                </tr>
                <tr>
                    <td class="daily-sales-amount-td" colspan="2">PHP 1400</td>
                </tr>
            </table>

            <table class="notice">
                <tr>
                    <td class="img-td"><img src="img/alert-circle-outline.svg" alt=""></td>
                    <td class="notice-text-td">NOTICE</td>
                </tr>
                <tr>
                    <td class="notice-td" colspan="2"><li><a href="#">Products low level!</a></li></td>
                </tr>
            </table>
        </nav>

        
            <table class="add-product-table">
                <form action="" method="post">
                    <tr>
                        <td class="close" colspan="4"><a href="products.php"><img src="img/close-circle.svg" alt=""></a></td>
                    </tr>

                    <tr>
                        <td>Product Name:</td>
                        <td><input type="text" name="pro_name" required></td>
                        
                        <td>Capital:</td>
                        <td><input type="number" name="del_price" required></td>
                    </tr>

                    <tr>
                        <td>Product Code:</td>
                        <td><input type="text" name="pro_code" required></td>
                        
                        <td>Delivery Quantity:</td>
                        <td><input type="number" name="del_quan" required></td>
                    </tr>

                    
                    <tr>
                        <td>Product Category:</td>
                        <td>
                            <select name="pro_categories">
                                <option value="Medicine">Medicine</option>
                                <option value="Goods">Goods</option>
                            </select>
                        </td>
                        
                        <td>Delivery Date:</td>
                        <td><input type="date" name="del_date"></td>
                    </tr>

                    <tr>
                        <td>Measurement:</td>
                        <td><input type="text" name="pro_measurement" required></td>

                        <td>Expiration Date:</td>
                        <td><input type="date" name="ex_date"></td>
                    </tr>
                    
                    <tr class="selling-price-tr">
                        <td>Selling Price:</td>
                        <td><input type="number" name="pro_selling_price" required></td>
                        <td class="button-td" colspan="2">
                            <input class="button-submit" type="submit" value="Save" name="save">
                        </td>
                    </tr>
                </form>
            </table>

    
    <?php else: ?>
        <div class="no-account-selected">
            <h1>No account selected</h1>
            <p class="Login"><a href="index.php">Login</a>
        </div>
    <?php endif; ?>
</body>
</html>