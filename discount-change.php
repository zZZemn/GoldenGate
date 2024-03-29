<?php
session_start();

if (isset($_SESSION["user_id"])) {
    include("database.php");

    $sql = "SELECT * FROM user
            WHERE user_no = {$_SESSION["user_id"]}";
    $result = $connect->query($sql);
    $user = $result->fetch_assoc();
}

$currentTaxDiscount = "SELECT * FROM `payment_vat_discount`";
$currentTaxDiscountRes = $connect->query($currentTaxDiscount);
$curDisRes = $currentTaxDiscountRes->fetch_assoc();

$curDiscount = $curDisRes['discount'];

if(isset($_POST['save'])) 
    {
    $discount = $_POST['discount'];
    $updateDis = "UPDATE `payment_vat_discount` SET `discount`='$discount' WHERE id = 0";

    if($connect->query($updateDis) == true)
    {
        header("location: maintenance.php");
    }

    else
    {
        echo '<script type="text/javascript">alert("Invalid Input!");</script>';     
    }
    }

?>


<html>
    <head>
        <title>Change Discount</title>
        <link rel="stylesheet" href="css/change-discount.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    </head>
    <body>
        <?php if (isset($user)): ?>
            
            <form action="" method="post">
                <h1>Discount Update</h1>
                <input class="text" step="0.01" type="number" required name="discount" value="<?php echo $curDiscount ?>">
                <input class="btn" type="submit" name="save" value="save">
            </form>

        <?php else: ?>
            <div class="no-account-selected">
                <h1>No account selected</h1>
                <p class="Login"><a href="index.php">Login</a>
            </div>
        <?php endif; ?>
    </body>
</html>
