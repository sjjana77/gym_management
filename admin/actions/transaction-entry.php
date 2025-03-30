<?php

function insertTransaction($conn, $postData)
{
    // Extract values from $postData
    $package_data_id = $postData['package_data_id'] ?? null;
    $members_id = $postData['members_id'] ?? null;
    $package_amount = $postData['package_amount'] ?? null;
    $cur_pending_amount = $postData['cur_pending_amount'] ?? null;
    $package_discount = $postData['package_discount'] ?? null;
    $cur_pay_amount = $postData['cur_pay_amount'] ?? null;
    $cur_pay_status = $postData['cur_pay_status'] ?? null;
    $payment_mode = $postData['payment_mode'] ?? null;
    $date = $postData['date'] ?? date('Y-m-d'); // Default to today if not provided
    $created_by = $postData['created_by'] ?? $_SESSION['user_id']; // Default value

    // SQL query for insertion
    $query = "INSERT INTO transactions 
        (package_data_id, members_id, package_amount, cur_pending_amount, package_discount, cur_pay_amount, cur_pay_status, payment_mode, date, created_by) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare statement
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("iiiiiiisss", $package_data_id, $members_id, $package_amount, $cur_pending_amount, $package_discount, $cur_pay_amount, $cur_pay_status, $payment_mode, $date, $created_by);

    // Execute the query
    if ($stmt->execute()) {
        return "Transaction inserted successfully!";
    } else {
        return "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    session_start();
    include "dbcon.php";
    $result = insertTransaction($con, $_POST);
    if ($result === "Transaction inserted successfully!") {
        // Extract values from $_POST
        $package_data_id = $_POST['package_data_id'] ?? null;
        $cur_pay_amount = $_POST['cur_pay_amount'] ?? null;
        $cur_pending_amount = $_POST['cur_pending_amount'] ?? null;
        $status = ($cur_pending_amount == 0) ? 2 : 1; // If no pending amount, set status to 2 else 1

        // Prepare update query
        $updateQuery = "UPDATE packages_data SET pay_amount = ?, cur_pending_amount = ?, status = ? WHERE id = ?";
        $updateStmt = $con->prepare($updateQuery);

        if ($updateStmt === false) {
            die("Update prepare failed: " . $con->error);
        }

        // Bind parameters
        $updateStmt->bind_param("iiii", $cur_pay_amount, $cur_pending_amount, $status, $package_data_id);

        // Execute update query
        if ($updateStmt->execute()) {
            echo "Transaction inserted and package updated successfully!";
        } else {
            echo "Error updating package: " . $updateStmt->error;
        }

        $updateStmt->close();
    } else {
        echo "Error inserting transaction: " . $result;
    }
}

?>