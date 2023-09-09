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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Login</title>
</head>
<body>


    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="#"><img src="assets/img/logo.webp" alt="Level Fit Studio Logo" height="100px"></a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-left-links navbar-nav ">
                <li class="nav-item active">
                    <a class="nav-link" href="https://www.levelfitstudio.com/">Naslovna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://www.levelfitstudio.com/o-nama">O nama</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://www.levelfitstudio.com/kontakt">Kontakt</a>
                </li>
            </ul>
            <ul class="navbar-right-links navbar-nav "> <!-- Links on the right side -->
                <li class="nav-item">
                    <a class="nav-link" href="https://www.levelfitstudio.com/galerija">Galerija</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://www.levelfitstudio.com/blog">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://www.levelfitstudio.com/programi">Programi</a>
                </li>
            </ul>
        </div>
    </nav>



    <div class="login-container">
        <h2>Login</h2>
        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username"><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password"><br>
            <div>
            <?php
                if(isset($_SESSION['error'])) {
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                }
                ?>
            </div>

            <input type="submit" value="Login">
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>