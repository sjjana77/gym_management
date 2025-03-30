<?php
include "dbcon.php";
$qry = "SELECT * FROM packages_info WHERE is_obsolete = 0";
$result = mysqli_query($con, $qry);
$packages_info = [];
while ($row = mysqli_fetch_assoc($result)) {
    $packages_info[] = $row;
}
?>