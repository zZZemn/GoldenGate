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
    <title>Point Of Sales</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/pos.css">
</head>
<body>
    <?php if (isset($user)): ?>
        <nav>
            <img src="img/ggd-logo-plain.png" alt="GGD">
            <h3>GOLDEN GATE DRUGSTORE</h3>
            <h5><?php echo $time?> - <?php echo $date; ?></h5>
            <h3><?php echo $user['f_name']." ".$user['l_name']?></h3>
            <?php if($user['user_type'] == "Administrator")
                    {
                        echo "<hr>";
                        echo "<h3><a href='goldengate.php'>Admin Page</a></h3>";
                    } 
                    else
                    {
                        echo "<h3><a href='logout.php'><img src='img/log-out-outline.svg'></a></h3>";
                    }
            ?>
        </nav>

    <?php else: ?>
        <div class="no-account-selected">
            <h1>No account selected</h1>
            <p class="Login"><a href="index.php">Login</a>
        </div>
    <?php endif; ?>
</body>
</html>