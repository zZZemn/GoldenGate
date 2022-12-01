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
            <div class="nav-links">
                <div class="link"><img src="img/person-circle-outline.svg" alt="person-circel-outline"><a class="profile" href="#"><?php echo $user["f_name"]." ".$user["mi"]." ".$user["l_name"] ?></a></div>
                <div class="link"><img src="img/reader-outline.svg" alt="person-circel-outline"><a class="sales-trans" href="#">Sales Transaction</a></div>
            </div>
        </nav>


    <?php else: ?>
        <div class="no-account-selected">
            <h1>No account selected</h1>
            <p class="Login"><a href="index.php">Login</a>
        </div>
    <?php endif; ?>
</body>
</html>