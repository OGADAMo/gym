<?php
require_once 'config.php';
if (!isset($_SESSION['admin_id'])) {
    header('location: index.php');
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row mb-5">
            <div class="row mb-6">
                <h2>Register Member</h2>
                <form action="register_mamber.php" method="post" enctype="multipart/form-data">
                        First Name: <input class="form-control" type="text" name="first_name"><br>
                        Last Name: <input class="form-control" type="text" name="last"><br>
                        Email: <input class="form-control" type="email" name="email"><br>
                        Phone Number: <input class="form-control" type="text" name="phone_number"><br>
                        Training Plan:
                        <select class="form-control" name="training_plan_id">

                        </select><br>
                        <input type="hidden" name="photo_path" id="photoPathInput"></input>
                        <div id="dropzone-upload" class="dropzone mt-4 border-dashed"></div>
                        <input class="btn btn-primary mt-3" type="submit" value="Register Member">
                </form>
            </div>
        </div>
    </div>
</body>
</html>