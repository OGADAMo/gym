<?php

require_once 'config.php';


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $photo_path = $_POST['photo_path'];
    
    $sql = "INSERT INTO trainers (first_name, last_name, email, photo_path, phone_number) VALUES (?, ?, ?, ?, ?)";

    $run = $conn->prepare($sql);
    $run->bind_param("sssss", $first_name, $last_name, $email, $photo_path, $phone_number);
    $run->execute();

        
    $_SESSION['success_message'] = "Novi trener uspjesno dodan";
    header("location: admin_dashboard.php");
}
?>