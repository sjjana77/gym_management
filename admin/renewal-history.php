<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:../index.php');
    exit();
}

include 'dbcon.php'; // Include DB connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Renewal History</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.1/css/fixedHeader.dataTables.min.css" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/custom.css" />
    <link rel="stylesheet" href="../css/matrix-style.css" />
    <link rel="stylesheet" href="../css/matrix-media.css" />
    <link rel="stylesheet" href="../font-awesome/css/all.css" />
    <style>
        select[name='memberTable_length'] {
            position: relative !important;
            top: 5px !important;
        }

        #memberTable_filter {
            position: relative !important;
            top: 5px !important;
        }
        .hidden{
            display: none;
        }
    </style>
</head>

<body>

    <div id="header">
        <h1><a href="dashboard.php">Perfect Gym Admin</a></h1>
    </div>

    <?php include 'includes/topheader.php'; ?>
    <?php $page = 'list-transactions';
    include 'includes/sidebar.php'; ?>

    <div id="content">
        <div id="content-header">
            <div id="breadcrumb">
                <a href="index.php" class="tip-bottom"><i class="fas fa-home"></i> Home</a>
                <a href="#" class="current">Renewal History</a>
            </div>
            <?php
            include 'dbcon.php';
            $where = '';
            $h1 = '';
            $select = ',m.fullname, m.contact, m.user_id ';
            $hidden = '';
            if (isset($_GET['id']) && $_GET['id'] != "") {
                $hidden = 'hidden';
                $h1 = ' - '.$_GET['name'] . " (".$_GET["id"].")";
                $where = " AND pd.members_id = '".$_GET["id"]."' ";
            }
            ?>
            <h1>Renewal History<?= $h1 ?> </h1>
        </div>

        <div class="container-fluid">
            <hr>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon"><i class="fas fa-file-invoice-dollar"></i></span>
                            <h5>Renewal Package Details</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table id="memberTable" class='display nowrap' style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th class="<?= $hidden ?>">Member ID</th>
                                        <th class="<?= $hidden ?>">Name</th>
                                        <th class='<?= $hidden ?>'>Contact</th>
                                        <th>Package</th>
                                        <th>Package Amount</th>
                                        <th>Discount</th>
                                        <th>Amount Payable</th>
                                        <th>Paid Amount</th>
                                        <th>Remaining Amount</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT pi.package_name, pd.package_amount, pd.discount, pd.pay_amount, pd.pending_amount, pd.effective_from, pd.end_date {$select}
                                    FROM packages_data as pd
                                    left join packages_info as pi on pi.id = pd.package_id
                                    LEFT JOIN members AS m ON m.user_id = pd.members_id 
                                    WHERE pi.id IS NOT NULL {$where}
                                    order by pd.id desc";
                                    $result = mysqli_query($conn, $query);
                                    $sno = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $amount_payable = $row['package_amount'] - $row['discount'];
                                        echo "<tr>";
                                        echo "<td>{$sno}</td>";
                                        echo "<td class='{$hidden}'>{$row['user_id']}</td>";
                                        echo "<td class='{$hidden}'>{$row['fullname']}</td>";
                                        echo "<td class='{$hidden}'>{$row['contact']}</td>";
                                        echo "<td>{$row['package_name']}</td>";
                                        echo "<td>₹{$row['package_amount']}</td>";
                                        echo "<td>₹{$row['discount']}</td>";
                                        echo "<td>₹{$amount_payable}</td>";
                                        echo "<td>₹{$row['pay_amount']}</td>";
                                        echo "<td>₹{$row['pending_amount']}</td>";
                                        echo "<td>{$row['effective_from']}</td>";
                                        echo "<td>{$row['end_date']}</td>";
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

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <?php
    include "pay_amount_dialog.php";
    ?>
</body>

</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.1/js/dataTables.fixedHeader.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialize DataTable
        var table = $('#memberTable').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            paging: true,
            columnDefs: [
                { targets: "_all", className: "dt-left" }  // Align all columns to left
            ]
        });

        // Clone header row for search inputs
        $('#memberTable thead tr').clone(true).addClass('filters').appendTo('#memberTable thead');

        // Add filtering inputs
        $('#memberTable thead tr.filters th').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" style="width:100%;display:block;color:#000;" placeholder="' + title + '" />');

            $('input', this).on('click', function (e) {
                e.stopPropagation(); // Prevent sorting when clicking input field
            });

            $('input', this).on('keyup change', function () {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        // Disable sorting on the cloned filter row
        table.columns().every(function () {
            $(this.header()).removeClass('sorting sorting_asc sorting_desc');
        });
        // Fix Bootstrap dropdown inside DataTables
        $(document).on("click", ".dropdown-toggle", function (e) {
            $(this).next(".dropdown-menu").toggle();
            e.stopPropagation(); // Prevent Bootstrap from closing immediately
        });
    });
</script>
<script src="pay_amount_modal.js"></script>