<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $training_plan_id = $_POST['training_plan_id'];
    $trainer_id = 0;
    $photo_path = $_POST['photo_path'];
    $access_card_pdf = "";

    $sql = "INSERT INTO members 
        (first_name, last_name, email, phone_number, photo_path, training_plan_id, trainer_id, access_card_pdf)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $run = $conn->prepare($sql);
    $run->bind_param("sssssiis", $first_name, $last_name, $email, $phone_number, $photo_path, $training_plan_id, $trainer_id, $access_card_pdf);
    $run->execute();
    
    $_SESSION['success_message'] = "Clan teretane uspjesno dodan";
    header("location: admin_dashboard.php");
}
?>