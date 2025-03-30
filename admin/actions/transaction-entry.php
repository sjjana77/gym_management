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
    $created_by = $postData['created_by'] ?? 'system'; // Default value

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


?>