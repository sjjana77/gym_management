<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('location:../index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gym System Admin</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="../css/matrix-style.css" />
    <link rel="stylesheet" href="../css/matrix-media.css" />
    <link href="../font-awesome/css/fontawesome.css" rel="stylesheet" />
    <link href="../font-awesome/css/all.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/jquery.gritter.css" />
</head>
<body>

<div id="header">
    <h1><a href="dashboard.html">Perfect Gym Admin</a></h1>
</div>

<?php include 'includes/topheader.php'?>
<?php $page='add-package'; include 'includes/sidebar.php'?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a> <a href="#" class="tip-bottom">Manage Packages</a> <a href="#" class="current">Add Package</a> </div>
        <h1>Add Package</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="fas fa-align-justify"></i> </span>
                        <h5>Package Details</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form action="add-package-req.php" method="POST" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">Package Name* :</label>
                                <div class="controls">
                                    <input type="text" class="span11" name="package_name" required />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Package Duration* :</label>
                                <div class="controls">
                                    <input type="text" class="span11" name="package_duration" required />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Package Description :</label>
                                <div class="controls">
                                    <textarea class="span11" name="package_description"></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Package Service :</label>
                                <div class="controls">
                                    <input type="text" class="span11" name="package_service" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Package Amount* :</label>
                                <div class="controls">
                                    <input type="number" class="span11" name="package_amount" required />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Status :</label>
                                <div class="controls">
                                    <select name="status" required>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Type :</label>
                                <div class="controls">
                                    <select name="type" required>
                                        <option value="Monthly">Monthly</option>
                                        <option value="Quarterly">Quarterly</option>
                                        <option value="Half-Yearly">Half-Yearly</option>
                                        <option value="Yearly">Yearly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Package Tax* :</label>
                                <div class="controls">
                                    <input type="number" class="span11" name="package_tax" required />
                                </div>
                            </div>
                            <div class="form-actions text-center">
                                <button type="submit" class="btn btn-success">Submit Package Details</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div id="footer" class="span12"> <?php echo date("Y");?> &copy; Developed By Naseeb Bajracharya</div>
</div>

<script src="../js/jquery.min.js"></script> 
<script src="../js/bootstrap.min.js"></script> 
<script src="../js/matrix.js"></script> 
</body>
</html>