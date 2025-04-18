<?php
include "./dbcon.php";
include 'transaction-entry.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $members_id = $_POST["members_id"];
    $package_id = $_POST["package_id"];
    $package_amount = $_POST["package_amount"];
    $discount = isset($_POST["package_discount"]) ? $_POST["package_discount"] : "";
    $pay_amount = $_POST["pay_amount"];
    $pending_amount = $_POST["pending_amount"];
    $payment_mode = $_POST["payment_mode"];
    $status = $pending_amount == 0 ? 2 : ($pending_amount > 0 ? 1 : 0);
    $package_duration = $_POST['package_duration'];
    $dor = $_POST['date'];
    $created_by = $_SESSION['user_id'];
    // $end_date = date('Y-m-d', strtotime($dor . " + $package_duration days")); //count after a day
    $end_date = date('Y-m-d', strtotime($dor . " + " . ($package_duration - 1) . " days"));
    $qry = "INSERT INTO packages_data(members_id,package_id,effective_from,end_date,package_amount,discount,pay_amount,pending_amount,pay_status,created_by) values ('$members_id','$package_id','$dor','$end_date','$package_amount','$discount','$pay_amount','$pending_amount','$status','$created_by')";
    $result = mysqli_query($con, $qry); //query executes
    if ($result) {
        $_POST['package_data_id'] = mysqli_insert_id($con);
        $_POST['cur_pending_amount'] = $pending_amount;
        $_POST['cur_pay_amount'] = $pay_amount;
        $_POST['cur_pay_status'] = $status;
        $_POST['created_by'] = $_SESSION['user_id'];
        insertTransaction($con, $_POST);
    }
}
?>