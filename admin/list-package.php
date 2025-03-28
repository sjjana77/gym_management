<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:../index.php');
    exit();
}

include '../includes/db_connect.php'; // Include DB connection

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>List Packages</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/matrix-style.css" />
    <link rel="stylesheet" href="../css/matrix-media.css" />
    <link rel="stylesheet" href="../font-awesome/css/all.css" />
</head>
<body>

<div id="header">
    <h1><a href="dashboard.php">Perfect Gym Admin</a></h1>
</div>

<?php include 'includes/topheader.php'; ?>
<?php $page = 'list-package'; include 'includes/sidebar.php'; ?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> 
            <a href="index.php" class="tip-bottom"><i class="fas fa-home"></i> Home</a> 
            <a href="#" class="current">List Packages</a>
        </div>
        <h1>Package List</h1>
    </div>
    
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> 
                        <span class="icon"><i class="fas fa-box"></i></span>
                        <h5>Package Details</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Package Name</th>
                                    <th>Package Description</th>
                                    <th>Duration</th>
                                    <th>Service</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Added By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM packages_info 
                                          where is_obsolete = 0
                                          ORDER BY id DESC";
                                $result = mysqli_query($conn, $query);
                                $sno = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>{$sno}</td>";
                                    echo "<td>{$row['package_name']}</td>";
                                    echo "<td>{$row['package_duration']} Months</td>";
                                    echo "<td>{$row['package_type']}</td>";
                                    echo "<td><span class='label " . ($row['status'] == 'Active' ? 'label-success' : 'label-danger') . "'>{$row['status']}</span></td>";
                                    echo "<td>$ {$row['amount']}</td>";
                                    echo "<td>{$row['username']}</td>";
                                    echo "<td>
                                            <div class='btn-group'>
                                                <button class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>Action <span class='caret'></span></button>
                                                <ul class='dropdown-menu'>
                                                    <li><a href='view-package.php?id={$row['id']}'><i class='fas fa-eye'></i> View</a></li>
                                                    <li><a href='edit-package.php?id={$row['id']}'><i class='fas fa-edit'></i> Edit</a></li>
                                                    <li><a href='delete-package.php?id={$row['id']}' onclick='return confirm(\"Are you sure?\");'><i class='fas fa-trash'></i> Delete</a></li>
                                                </ul>
                                            </div>
                                          </td>";
                                    echo "</tr>";
                                    $sno++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>