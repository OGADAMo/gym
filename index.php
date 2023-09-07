<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];


    $sql = "SELECT admin_id, password FROM admins WHERE username = ?";

    $run = $conn->prepare($sql);
    $run->bind_param("s", $username);
    $run->execute();

    $results = $run->get_result();

    if ($results->num_rows == 1) {
        $admin = $results->fetch_assoc();

        if(password_verify($password, $admin['password'])){
            $_SESSION['admin_id'] = $admin['admin_id'];
            header('location: admin_dashboard.php');
            
        } else {
            $_SESSION['error'] = "Netocan Password!";
            header('location: index.php');
            exit();
        }
    }
    else {
        $_SESSION['error'] = "Netacan Username!";
        header('location: index.php');
        exit();
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <?php
    if(isset($_SESSION['error'])) {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    }
    ?>
    <form action="" method="POST">
        Username: <input type="text" name="username"><br>
        Password: <input type="password" name="password"><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>