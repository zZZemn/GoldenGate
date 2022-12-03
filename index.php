<?php
include("time&date.php");
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    include("database.php");
    
    $sql = sprintf("SELECT * FROM user
                    WHERE username = '%s'",
                   $connect->real_escape_string($_POST["email"]));
    
    $result = $connect->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password"]) && $user["status"] == "Active") 
        {
            session_start();
            $_SESSION["user_id"] = $user["user_no"];
            
            if($user["user_type"] == "Administrator")
                {
                    header("Location: goldengate.php");
                }
            else if($user["user_type"] === "Pharmacist")
                {
                    header("Location: pos.php");
                }
            exit;
        }
    }
    
    $is_invalid = true;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
</head>
<body>
    <nav>
        <h4><?php echo "".$date; ?></h4>
        <h4><?php echo "".$time; ?></h4>
    </nav>

        <div class="login-form-container">
            <img src="img/ggd-logo.png" alt="" class="image">
            
            <hr>

            <?php if ($is_invalid): ?>
                <em>Wrong email or password!</em>
            <?php endif; ?>

            <form method="post">
                    <input placeholder="Username" type="text" name="email" id="email"
                    value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
                
                    <input placeholder="Password" type="password" name="password" id="password">

                    <button>Login</button>
            </form>

            <a href="#">forgot password?</a>
        </div>

</body>
</html>