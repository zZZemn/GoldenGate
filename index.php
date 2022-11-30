<?php
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    include("database.php");
    
    $sql = sprintf("SELECT * FROM user
                    WHERE username = '%s'",
                   $connect->real_escape_string($_POST["email"]));
    
    $result = $connect->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password"])) {
            
            session_start();
            
            $_SESSION["user_id"] = $user["user_no"];
            
            header("Location: goldengate.php");
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
</head>
<body>
    <div class="login-form-container">
        <img src="img/ggd-logo.png" alt="" class="image">

        <?php if ($is_invalid): ?>
            <em>Wrong email or password!</em>
        <?php endif; ?>

        <form method="post">
                <input placeholder="username" type="text" name="email" id="email"
                value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
            
                <input type="password" name="password" id="password">

                <button>Login</button>
        </form>

        <a href="#">forgot password?</a>
    </div>
</body>
</html>