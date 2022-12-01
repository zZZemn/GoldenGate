<?php 
include("time&date.php");
session_start();

if (isset($_SESSION["user_id"])) {
    include("database.php");

    $sql = "SELECT * FROM user
            WHERE user_no = {$_SESSION["user_id"]}";
    $result = $connect->query($sql);
    $user = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Golden Gate Drugstore</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/goldengate.css">
</head>
<body>
    <?php if (isset($user)): ?>
        <nav class="top-nav">
            <a href="#"><img src="img/ggd-logo.png" alt="GGD"></a>
            <h1>GOLDEN GATE DRUGSTORE</h1>
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
                    <td><a class="inventory" href="#">INVENTORY</a></td>
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


    <?php else: ?>
        <div class="no-account-selected">
            <h1>No account selected</h1>
            <p class="Login"><a href="index.php">Login</a>
        </div>
    <?php endif; ?>
</body>
</html>