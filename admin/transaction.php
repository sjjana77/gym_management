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
    <title>List Transactions</title>
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
                <a href="#" class="current">List Transactions</a>
            </div>
            <h1>Transaction List</h1>
        </div>

        <div class="container-fluid">
            <hr>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon"><i class="fas fa-file-invoice-dollar"></i></span>
                            <h5>Transaction Details</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table id="memberTable" class='display nowrap' style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Bill Date</th>
                                        <th>Member ID</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Package</th>
                                        <th>Package Amount</th>
                                        <th>Discount</th>
                                        <th>Paid Amount</th>
                                        <th>Remaining Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT t.*, m.fullname, m.contact, pi.package_name, pd.package_amount, pd.discount, pd.pay_amount, pd.pending_amount 
                                    FROM transactions AS t 
                                    LEFT JOIN members AS m ON m.user_id = t.members_id 
                                    LEFT JOIN packages_data AS pd ON pd.id = t.package_data_id 
                                    LEFT JOIN packages_info AS pi ON pi.id = pd.package_id 
                                    ORDER BY t.date, t.id DESC";
                                    $result = mysqli_query($conn, $query);
                                    $sno = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $status = ($row["cur_pay_status"] == 2) ? 'Full' :
                                            (($row["cur_pay_status"] == 1) ? 'Partial' : 'Pending');
                                        echo "<tr>";
                                        echo "<td>{$sno}</td>";
                                        echo "<td>{$row['date']}</td>";
                                        echo "<td>{$row['members_id']}</td>";
                                        echo "<td>{$row['fullname']}</td>";
                                        echo "<td>{$row['contact']}</td>";
                                        echo "<td>{$row['package_name']}</td>";
                                        echo "<td>₹{$row['package_amount']}</td>";
                                        echo "<td>₹{$row['discount']}</td>";
                                        echo "<td>₹{$row['cur_pay_amount']}</td>";
                                        echo "<td>₹{$row['pending_amount']}</td>";
                                        echo "<td>{$status}</td>";
                                        echo "<td>
                                            <div class='btn-group'>
                                                <button class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>Action <span class='caret'></span></button>
                                                <ul class='dropdown-menu'>
                                                   <li><a class='dropdown-item edit-btn' href='#'
                                                    data-id='{$row['members_id']}'
                                                    data-package_amount='{$row['package_amount']}'
                                                    data-package_discount='{$row['discount']}'
                                                    data-amount_paid='{$row['pay_amount']}'
                                                    data-package_data_id='{$row['package_data_id']}'
                                                    data-cur_pending_amount='{$row['pending_amount']}'
                                                    ><i class='fas fa-money-bill'></i> Pay Amount</a></li>
                                                    <li><a href='edit-transaction.php?id={$row['id']}'><i class='fas fa-edit'></i> Edit</a></li>
                                                    <li><a href='delete-transaction.php?id={$row['id']}' onclick='return confirm(\"Are you sure?\");'><i class='fas fa-trash'></i> Delete</a></li>
                                                    <li><a href='renew-transaction.php?id={$row['id']}'><i class='fas fa-redo'></i> Renew</a></li>
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