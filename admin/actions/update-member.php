<?php
include "dbcon.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $userId = $_POST['user_id'];
  $fullname = $_POST['fullname'];
  $gender = $_POST['gender'];
  $contact = $_POST['contact'];
  $address = $_POST['address'];

  $query = "UPDATE members SET fullname = ?, gender = ?, contact = ?, address = ? WHERE user_id = ?";
  $stmt = $con->prepare($query);
  $stmt->bind_param("ssssi", $fullname, $gender, $contact, $address, $userId);

  if ($stmt->execute()) {
    // echo "<script>alert('Member updated successfully!'); window.location='members.php';</script>";
  } else {
    // echo "<script>alert('Error updating member.'); window.location='members.php';</script>";
  }

  $stmt->close();
  $con->close();
}
?>
