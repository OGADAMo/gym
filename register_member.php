<?php
require_once 'config.php';
require_once 'fpdf186/fpdf.php';

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

    $member_id = $conn->insert_id;

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    $pdf->Cell(0, 10, 'Member Information', 0, 1, 'C');
    $pdf->Ln(10);
    
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, 'First Name:', 0);
    $pdf->Cell(0, 10, $first_name, 0, 1);
    
    $pdf->Cell(40, 10, 'Last Name:', 0);
    $pdf->Cell(0, 10, $last_name, 0, 1);
    
    $pdf->Cell(40, 10, 'Email:', 0);
    $pdf->Cell(0, 10, $email, 0, 1);
    
    $pdf->Cell(40, 10, 'Phone Number:', 0);
    $pdf->Cell(0, 10, $phone_number, 0, 1);
    
    $pdf->Cell(40, 10, 'Training Plan ID:', 0);
    $pdf->Cell(0, 10, $training_plan_id, 0, 1);
    
    $pdf->Cell(40, 10, 'Trainer ID:', 0);
    $pdf->Cell(0, 10, $trainer_id, 0, 1);

    $filename = 'access_cards/access_card_'. $member_id . '.pdf';
    $pdf->Output('f', $filename);

    $sql = "UPDATE members SET access_card_pdf = '$filename' WHERE member_id = $member_id";
    $conn->query($sql); 
    
    $_SESSION['success_message'] = "Clan teretane uspjesno dodan";
    header("location: admin_dashboard.php");
}
?>