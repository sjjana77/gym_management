<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('location:../index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Gym System Admin</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.1/css/fixedHeader.dataTables.min.css" />
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/bootstrap-responsive.min.css" />
  <link rel="stylesheet" href="../css/matrix-style.css" />
  <link rel="stylesheet" href="../css/matrix-media.css" />
  <link href="../font-awesome/css/fontawesome.css" rel="stylesheet" />
  <link href="../font-awesome/css/all.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/custom.css" />

  <style>
    /* Fix dropdown menu alignment inside DataTable */
    .dropdown-menu {
      position: absolute !important;
      will-change: transform;
      transform: translate3d(0px, 0px, 0px) !important;
      z-index: 1050;
    }
  </style>
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
    <h1><a href="dashboard.html">Perfect Gym Admin</a></h1>
  </div>

  <?php include 'includes/topheader.php' ?>
  <?php $page = "members";
  include 'includes/sidebar.php' ?>

  <div id="content">
    <div id="content-header">
      <h1 class="text-center">Registered Members List <i class="fas fa-group"></i></h1>
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class='widget-box'>
            <div class='widget-title'> <span class='icon'><i class='fas fa-th'></i></span>
              <h5>Member Table</h5>
            </div>
            <div class='widget-content nopadding'>
              <?php
              include "dbcon.php";
              $qry = "SELECT m.*, pd.pay_amount, pi.package_name, pd.package_amount, pd.discount, pd.pay_amount, pd.pending_amount, pd.end_date, pd.effective_from, pd.id as package_data_id FROM members as m 
                LEFT JOIN packages_data AS pd ON pd.id = ( SELECT MAX(pd_inner.id) FROM packages_data AS pd_inner WHERE pd_inner.members_id = m.user_id ) 
                LEFT JOIN packages_info AS pi on pi.id = pd.package_id 
                WHERE m.is_obsolete = 0 ORDER BY m.user_id DESC";
              $result = mysqli_query($con, $qry);
              ?>
              <table id="memberTable" class='display nowrap' style="width:100%">
                <thead>
                  <tr>
                    <th>Sno</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Package</th>
                    <th>Package Amount</th>
                    <th>Discount</th>
                    <th>Amount Payable</th>
                    <th>Amount Paid</th>
                    <th>Remaining Amount</th>
                    <th>End Date</th>
                    <th>Days Left</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $cnt = 1;
                  while ($row = mysqli_fetch_array($result)) {
                    $amount_payable = $row['package_amount'] - $row['discount'];
                    if (strtotime($row['end_date'])) {
                      $today = new DateTime(); // Get today's date
                      $end_date = new DateTime($row['end_date']);
                      if ($today > $end_date) {
                        $day_left = "-"; // If the end date has passed, return "-"
                      } else {
                        $day_left = $today->diff($end_date)->days - 1;
                      }
                    } else {
                      $day_left = "-"; // If the end_date is invalid, return "-"
                    }
                    $status = $day_left > 0 ? 'Active' : 'Expired';
                    $pay_amount_disable = $row['pending_amount'] == 0 ? 'disabled' : '';
                    $renewal_disable = $row['pending_amount'] != 0 ? 'disabled' : '';
                    echo "<tr>
                        <td>{$cnt}</td>
                        <td>{$row['user_id']}</td>
                        <td>{$row['fullname']}</td>
                        <td>{$row['contact']}</td>
                        <td>{$row['package_name']}</td>
                        <td>₹{$row['package_amount']}</td>
                        <td>₹{$row['discount']}</td>
                        <td>₹{$amount_payable}</td>
                        <td>₹{$row['pay_amount']}</td>
                        <td>₹{$row['pending_amount']}</td>
                        <td>{$row['end_date']}</td>
                        <td>{$day_left}</td>
                        <td>{$status}</td>
                        <td>
                          <div class='btn-group'>
                            <button class='btn btn-primary dropdown-toggle action-btn' data-bs-toggle='dropdown'>
                              Action <span class='caret'></span>
                            </button>
                            <ul class='dropdown-menu'>
                            <li><a class='dropdown-item edit-btn {$pay_amount_disable}' href='#'
                            data-id='{$row['user_id']}'
                            data-package_amount='{$row['package_amount']}'
                            data-package_discount='{$row['discount']}'
                            data-amount_paid='{$row['pay_amount']}'
                            data-package_data_id='{$row['package_data_id']}'
                            data-cur_pending_amount='{$row['pending_amount']}'
                            ><i class='fas fa-money-bill'></i> Pay Amount</a></li>
                              <li><a class='dropdown-item renewal-btn {$renewal_disable}' href='#'
                              data-end_date='{$row['end_date']}'
                              data-members_id='{$row['user_id']}'
                              ><i class='fas fa-sync'></i> Renewal</a></li>
                              <li><a target='_blank' class='dropdown-item' href='renewal-history.php?id={$row['user_id']}&name={$row['fullname']}'><i class='fas fa-history'></i> Renewal History</a></li>
                              <li><a class='dropdown-item' href='#'><i class='fas fa-receipt'></i> Transactions</a></li>
                            </ul>
                          </div>
                        </td>
                      </tr>";
                    $cnt++;
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
  <?php
  include "pay_amount_dialog.php";
  ?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    $(document).ready(function () {

      $("#cur_pay_amount").on("input", function () {
        let packageAmount = parseFloat($("#package_amount").val()) || 0;
        let discount = parseFloat($("#package_discount").val()) || 0;
        let amountPaid = parseFloat($("#amount_paid").val()) || 0;
        let payAmount = parseFloat($(this).val()) || 0;

        let remainingAmount = (packageAmount - discount) - (amountPaid + payAmount);
        $("#cur_pending_amount").val(remainingAmount);
      });

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

      // Fix Bootstrap dropdown issue inside DataTable
      $('#memberTable').on('click', '.action-btn', function (e) {
        e.stopPropagation();
        let $menu = $(this).next('.dropdown-menu');
        $('.dropdown-menu').not($menu).hide();
        $menu.toggle();
      });

      $(document).click(function () {
        $('.dropdown-menu').hide();
      });

      $('.dropdown-menu').click(function (e) {
        e.stopPropagation();
      });

      $(document).on('click', '.pay-amount-btn', function (e) {
        e.preventDefault();

        // Set hardcoded values
        $("#modal_package_amount").val(1000);
        $("#modal_discount_amount").val(50);
        $("#modal_amount_paid").val(200);
        $("#modal_pay_amount").val(600);

        // Calculate remaining amount
        let packageAmount = 1000;
        let discount = 50;
        let amountPaid = 200;
        let payAmount = 600;
        let remainingAmount = (packageAmount - discount) - (amountPaid + payAmount);
        $("#modal_remaining_amount").val(remainingAmount);

        // Show modal
        $("#editPayAmountModal").modal('show');
      });

      $("#savePayAmount").click(function () {
        var payAmount = parseFloat($("#modal_pay_amount").val()) || 0;
        var packageAmount = parseFloat($("#modal_package_amount").val()) || 0;
        var discount = parseFloat($("#modal_discount_amount").val()) || 0;
        var amountPaid = parseFloat($("#modal_amount_paid").val()) || 0;

        var remainingAmount = (packageAmount - discount) - (amountPaid + payAmount);
        $("#modal_remaining_amount").val(remainingAmount);
        $("#pay_amount").val(payAmount);
        $("#editPayAmountModal").modal('hide');
      });


      $('#payAmount').on('input', function () {
        updateRemainingAmount();
      });

      function updateRemainingAmount() {
        let packageAmount = parseFloat($('#package_amount').val()) || 0;
        let discount = parseFloat($('#package_discount').val()) || 0;
        let amountPaid = parseFloat($('#amount_paid').val()) || 0;
        let payAmount = parseFloat($('#payAmount').val()) || 0;
        let remaining = (packageAmount - discount) - (amountPaid + payAmount);
        $('#remainingAmount').val(remaining);
      }
    });


  </script>
  <script src="pay_amount_modal.js"></script>

</body>

</html>