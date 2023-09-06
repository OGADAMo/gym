<?php 
require_once 'config.php';

$username = 'admin';
$password = 'sifra123';

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

echo $hashed_password;

$sql = "INSERT INTO admins (username, password"
?>