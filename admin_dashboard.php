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
    <?php if (isset($_SESSION['success_message'])) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['success_message']; unset($_SESSION['success_message'])?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Member List</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Trainer</th>
                            <th>Photo</th>
                            <th>Training Plan</th>
                            <th>Access Card</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php

                        $sql ="SELECT
                                    members.*,
                                    traning_plans.name AS training_plan_name,
                                    trainers.first_name AS trainer_first_name,
                                    trainers.last_name AS trainer_last_name
                                FROM
                                    `members`
                                LEFT JOIN traning_plans ON members.training_plan_id = traning_plans.plan_id
                                LEFT JOIN trainers ON members.trainer_id = trainers.trainer_id;";

                        $results = $conn->query($sql);
                        $results = $results->fetch_all(MYSQLI_ASSOC);
                        $select_members = $results;

                        foreach($results as $result) : ?>
                            <tr>
                                <td><?php echo $result['first_name'] ?></td>
                                <td><?php echo $result['last_name'] ?></td>
                                <td><?php echo $result['email'] ?></td>
                                <td><?php echo $result['phone_number'] ?></td>
                                <td><?php 
                                if($result['trainer_first_name']){
                                    echo $result['trainer_first_name'] . " " . $result['trainer_last_name'];
                                } else {
                                    echo "Nema trenera";
                                }
                                 ?></td>
                                <td><img src="<?php echo $result['photo_path'] ?>" alt="photo" width="60px" height="60px"></td>
                                <td>
                                    <?php 
                                        if ($result['training_plan_name']) {
                                            echo $result['training_plan_name'];
                                        } else {
                                            echo "Nema plana";

                                        }
                                        
                                    ?>
                                </td>
                                <td><a target="_blank" href="<?php echo $result['access_card_pdf'] ?>" >Access Card</a></td>
                                <td><?php echo $result['created_at'] ?></td>
                              
                                <td>
                                    <form action="delete_member.php" method="POST">
                                        <input type="hidden" name="member_id" value="<?php echo $result['member_id'] ?>">
                                        <button>DELETE</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                            
                    </tbody>
                </table>
            </div>

            <div class="col-md-12">
                <h2>Trainer List</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM trainers";
                            $run = $conn->query($sql);

                            $results = $run->fetch_all(MYSQLI_ASSOC);
                            $select_trainers = $results;
                            foreach ($results as $result) : ?>
                                <tr>
                                    <td><?php echo $result['first_name'] ?></td>
                                    <td><?php echo $result['last_name'] ?></td>
                                    <td><?php echo $result['email'] ?></td>
                                    <td><?php echo $result['phone_number'] ?></td>
                                    <td><?php echo $result['created_at'] ?></td>
                                </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        

        <div class="row mb-5">
            <div class="col-md-6">
                <h2>Register Member</h2>
                <form action="register_member.php" method="post" enctype="multipart/form-data">
                        First Name: <input class="form-control" type="text" name="first_name"><br>
                        Last Name: <input class="form-control" type="text" name="last_name"><br>
                        Email: <input class="form-control" type="email" name="email"><br>
                        Phone Number: <input class="form-control" type="text" name="phone_number"><br>
                        Training Plan:
                        <select class="form-control" name="training_plan_id">
                            <option value="" disabled selected>Training Plan</option>
                            <?php
                            $sql = "SELECT * FROM `traning_plans`"; // Fix the table name
                            $run = $conn->query($sql);
                            $results = $run->fetch_all(MYSQLI_ASSOC);
                    
                            foreach($results as $result){
                                echo "<option value='" . $result['plan_id'] . "'>" . $result['name'] . "</option>";
                            }    ?>
                        </select><br>
                        <input type="hidden" name="photo_path" id="photoPathInput"></input>
                        <div id="dropzone-upload" class="dropzone mt-4 border-dashed"></div>
                        <input class="btn btn-primary mt-3" type="submit" value="Register Member">
                </form>
            </div>

            <div class="col-md-6">
            <h2>Register Trainer</h2>
            <form action="register_trainer.php" method="post">
                First name: <input class="form-control" type="text" name="first_name"><br>
                Last name: <input class="form-control" type="text" name="last_name"><br>
                Email: <input class="form-control" type="text" name="email"><br>
                Phone Number: <input class="form-control" type="text" name="phone_number"><br>
                <input class="btn btn-primary" value="Register Trainer" type="submit">
            </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h2>Assign Trainer to Member</h2>
                <form action="assign_trainer.php" method="post">
                    <label for="">Select Member</label>
                    <select name="member" class="form-select">
                        <?php 
                        foreach($select_members as $member) : ?>

                        <option value="<?php echo $member['member_id']  ?>">
                            <?php echo $member['first_name'] . " " . $member['last_name']; ?>
                        </option>
                        <?php endforeach; ?>

                    </select>

                    <label for="">Select Trainer</label>
                    <select name="trainer" class="form-select">
                        <?php 
                            foreach($select_trainers as $trainer) : ?>

                        <option value="<?php echo $trainer['trainer_id']  ?>">
                            <?php echo $trainer['first_name'] . " " . $trainer['last_name']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>

                    <button type="Submit" class="btn btn-primary">Assign Trainer</button>
                </form>
            </div>
        </div>

        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        Dropzone.options.dropzoneUpload = {
    url: "upload_photo.php",
    paramName: "photo",
    maxFilesize: 20, // Maximum file size in MB
    acceptedFiles: "image/*", // Accept only image files
    init: function() {
        this.on("success", function(file, response) {
            // File upload success
            const jsonResponse = JSON.parse(response);

            if (jsonResponse.success) {
                document.querySelector("#photoPathInput").value = jsonResponse.photo_path;
            } else {
                console.error(jsonResponse.error);
            }
        });
    }
};

    </script>
</body>
</html>