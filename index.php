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

        if($admin['password'] === $password){
            echo "pass je tacan";
        } else {
            echo "paSS nijje tacan";
        }
    }
    else {
        $admin = $results->fetch_assoc();
        echo $admin;
        echo "admin ne postoji";
    }
    
}

else {
    echo "NIJE POSLANO";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <form action="" method="POST">
        Username: <input type="text" name="username"><br>
        Password: <input type="password" name="password"><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>