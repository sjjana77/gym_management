<?php
include('../dbcon.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the request body
    $data = json_decode(file_get_contents("php://input"), true);

    // Required field validation
    if (!isset($data['package_name']) || !isset($data['package_amount'])) {
        echo '<script>alert("Package name and amount are required!"); window.location="../add_package.php";</script>';
        exit();
    }

    // Sanitize required inputs
    $package_name = mysqli_real_escape_string($con, $data['package_name']);
    $package_amount = (int)$data['package_amount'];

    // Handle optional fields (if not set, assign NULL or default value)
    $package_duration = isset($data['package_duration']) ? (int)$data['package_duration'] : NULL;
    $package_description = isset($data['package_description']) ? mysqli_real_escape_string($con, $data['package_description']) : NULL;
    $package_service = isset($data['package_service']) ? mysqli_real_escape_string($con, $data['package_service']) : NULL;
    $package_status = isset($data['package_status']) ? (int)$data['package_status'] : 0; // Default: 0 (inactive)
    $package_type = isset($data['package_type']) ? (int)$data['package_type'] : NULL;
    $package_tax = isset($data['package_tax']) ? (int)$data['package_tax'] : 0; // Default: 0%

    // SQL Query to insert the data
    $sql = "INSERT INTO packages 
            (package_name, package_duration, package_description, package_service, package_amount, package_status, package_type, package_tax) 
            VALUES 
            ('$package_name', 
             " . ($package_duration !== NULL ? "'$package_duration'" : "NULL") . ", 
             " . ($package_description !== NULL ? "'$package_description'" : "NULL") . ", 
             " . ($package_service !== NULL ? "'$package_service'" : "NULL") . ", 
             '$package_amount', 
             '$package_status', 
             " . ($package_type !== NULL ? "'$package_type'" : "NULL") . ", 
             '$package_tax')";

    if ($con->query($sql) === TRUE) {
        echo '<script>window.location="../list-package.php";</script>';
        exit();
    } else {
        echo '<script>alert("Error: ' . $con->error . '"); window.location="../add_package.php";</script>';
        exit();
    }
} else {
    echo '<script>alert("Invalid request method"); window.location="../add_package.php";</script>';
    exit();
}
?>
