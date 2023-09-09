<?php
require_once 'config.php';

if (isset($_GET['what'])) {
    // Define allowed values for 'what' to enhance security
    $allowedTypes = ["members", "trainers"];

    if (in_array($_GET['what'], $allowedTypes)) {
        $sql = "SELECT * FROM " . $_GET['what'];

        // Fetch data from the database
        $results = $conn->query($sql);
        $results = $results->fetch_all(MYSQLI_ASSOC);

        // Output the data as a CSV file with each data point in a separate column
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=" . $_GET['what'] . ".csv");

        // Open the output stream
        $output = fopen('php://output', 'w');

        // Output each row with each data point in a separate column
        foreach ($results as $result) {
            $row = [];
            foreach ($result as $value) {
                $row[] = $value; // Each value goes into a separate column
            }
            fputcsv($output, $row);
        }

        // Close the output stream
        fclose($output);
    } else {
        echo "Invalid request";
    }
}
?>
