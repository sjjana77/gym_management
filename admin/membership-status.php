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
  </head>

  <body>
    <div id="header">
      <h1><a href="dashboard.html">Perfect Gym Admin</a></h1>
    </div>

    <?php include 'includes/topheader.php' ?>
    <?php $page = "members"; include 'includes/sidebar.php' ?>

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
                $qry = "SELECT m.*, pd.pay_amount, pi.package_name FROM members as m 
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
                      <th>Fullname</th>
                      <th>Gender</th>
                      <th>Contact Number</th>
                      <th>D.O.R</th>
                      <th>Address</th>
                      <th>Package</th>
                      <th>Amount Paid</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $cnt = 1;
                    while ($row = mysqli_fetch_array($result)) {
                      echo "<tr>
                        <td>{$cnt}</td>
                        <td>{$row['user_id']}</td>
                        <td>{$row['fullname']}</td>
                        <td>{$row['gender']}</td>
                        <td>{$row['contact']}</td>
                        <td>{$row['dor']}</td>
                        <td>{$row['address']}</td>
                        <td>{$row['package_name']}</td>
                        <td>₹{$row['pay_amount']}</td>        
                        <td>
                          <div class='btn-group'>
                            <button class='btn btn-primary dropdown-toggle action-btn' data-bs-toggle='dropdown'>
                              Action <span class='caret'></span>
                            </button>
                            <ul class='dropdown-menu'>
                            <li><a class='dropdown-item pay-amount-btn' href='#'><i class='fas fa-money-bill'></i> Pay Amount</a></li>
                              <li><a class='dropdown-item' href='#'><i class='fas fa-sync'></i> Renewal</a></li>
                              <li><a class='dropdown-item' href='#'><i class='fas fa-history'></i> Renewal History</a></li>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
      $(document).ready(function () {
        var table = $('#memberTable').DataTable({
          responsive: true,
          autoWidth: false,
          order: [],
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
          let packageAmount = parseFloat($('#packageAmount').val()) || 0;
          let discount = parseFloat($('#discount').val()) || 0;
          let amountPaid = parseFloat($('#amountPaid').val()) || 0;
          let payAmount = parseFloat($('#payAmount').val()) || 0;
          let remaining = (packageAmount - discount) - (amountPaid + payAmount);
          $('#remainingAmount').val(remaining);
        }
      });
    </script>

  <!-- Pay Amount Modal -->
  <div class="modal fade" id="editPayAmountModal" tabindex="-1" aria-labelledby="payAmountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Pay Amount</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="modal_package_amount" class="form-label">Package Amount</label>
              <input type="number" class="form-control" id="modal_package_amount" readonly>
            </div>
            <div class="mb-3">
              <label for="modal_discount_amount" class="form-label">Discount</label>
              <input type="number" class="form-control" id="modal_discount_amount" readonly>
            </div>
            <div class="mb-3">
              <label for="modal_amount_paid" class="form-label">Amount Paid</label>
              <input type="number" class="form-control" id="modal_amount_paid" readonly>
            </div>
            <div class="mb-3">
              <label for="modal_pay_amount" class="form-label">Pay Amount</label>
              <input type="number" class="form-control" id="modal_pay_amount">
            </div>
            <div class="mb-3">
              <label for="modal_remaining_amount" class="form-label">Remaining Amount</label>
              <input type="number" class="form-control" id="modal_remaining_amount" readonly>
            </div>
            <div class="mb-3">
              <label for="paymentMode" class="form-label">Payment Mode</label>
              <select class="form-control" id="paymentMode">
                <option value="cash">Cash</option>
                <option value="card">Card</option>
                <option value="upi">UPI</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="savePayAmount">Submit Payment</button>
        </div>
      </div>
    </div>
  </div>

    
  </body>

  </html>