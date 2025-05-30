<?php
session_start();
//the isset function to check username is already loged in and stored on the session
if (!isset($_SESSION['user_id'])) {
  header('location:../index.php');
}
include 'constants.php';
include 'getPackages_Info.php';
?>
<!-- Visit codeastro.com for more projects -->
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Gym System Admin</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/bootstrap-responsive.min.css" />
  <link rel="stylesheet" href="../css/fullcalendar.css" />
  <link rel="stylesheet" href="../css/matrix-style.css" />
  <link rel="stylesheet" href="../css/matrix-media.css" />
  <link rel="stylesheet" href="../css/custom.css" />
  <link href="../font-awesome/css/fontawesome.css" rel="stylesheet" />
  <link href="../font-awesome/css/all.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/jquery.gritter.css" />
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>

<body>

  <!--Header-part--><!-- Visit codeastro.com for more projects -->
  <div id="header">
    <h1><a href="dashboard.html">Perfect Gym Admin</a></h1>
  </div>
  <!--close-Header-part-->


  <!--top-Header-menu-->
  <?php include 'includes/topheader.php' ?>
  <!--close-top-Header-menu-->
  <!--start-top-serch-->
  <!-- <div id="search">
  <input type="hidden" placeholder="Search here..."/>
  <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
</div> -->
  <!--close-top-serch-->

  <!--sidebar-menu-->
  <?php $page = 'members-entry';
  include 'includes/sidebar.php' ?>
  <!--sidebar-menu-->
  <div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i>
          Home</a> <a href="#" class="tip-bottom">Manamge Members</a> <a href="#" class="current">Add Members</a> </div>
      <h1>Member Entry Form</h1>
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span6">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="fas fa-align-justify"></i> </span>
              <h5>Personal-info</h5>
            </div>
            <div class="widget-content nopadding">
              <form action="add-member-req.php" method="POST" class="form-horizontal">
                <div class="control-group">
                  <label class="control-label">Full Name :</label>
                  <div class="controls">
                    <input type="text" class="span11" name="fullname" placeholder="Fullname" />
                  </div>
                </div>
                <!-- <div class="control-group">
              <label class="control-label">Username :</label>
              <div class="controls">
                <input type="text" class="span11" name="username" placeholder="Username" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Password :</label>
              <div class="controls">
                <input type="password"  class="span11" name="password" placeholder="**********"  />
                <span class="help-block">Note: The given information will create an account for this particular member</span>
              </div>
            </div> -->
                <div class="control-group">
                  <label class="control-label">Gender :</label>
                  <div class="controls">
                    <select name="gender" required="required" id="select">
                      <option value="Male" selected="selected">Male</option>
                      <option value="Female">Female</option>
                      <option value="Other">Other</option>
                    </select>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">D.O.R :</label>
                  <div class="controls">
                    <input type="date" name="dor" class="span11" />
                    <span class="help-block">Date of registration</span>
                  </div>
                </div>


            </div>
            <div class="widget-title"> <span class="icon"> <i class="fas fa-align-justify"></i> </span>
              <h5>Contact Details</h5>
            </div>


            <div class="widget-content nopadding">
              <div class="form-horizontal">

                <div class="control-group">
                  <label for="normal" class="control-label">Contact Number</label>
                  <div class="controls">
                    <input type="number" id="mask-phone" name="contact" placeholder="9876543210"
                      class="span8 mask text">
                    <span class="help-block blue span8">(999) 999-9999</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Address :</label>
                  <div class="controls">
                    <input type="text" class="span11" name="address" placeholder="Address" />
                  </div>
                </div>
              </div>



            </div>
          </div>


        </div>



        <div class="span6">
          <div class="widget-box">
            <div class="widget-content nopadding">
              <div class="form-horizontal">
              </div>

              <div class="widget-title"> <span class="icon"> <i class="fas fa-align-justify"></i> </span>
                <h5>Package Details</h5>
              </div>
              <div class="widget-content nopadding">
                <div class="form-horizontal">
                  <div class="control-group">
                    <label for="normal" class="control-label">Package : </label>
                    <div class="controls">
                      <select name="package_id" class="package_id" required="required" id="select">
                        <option value="">Select Package</option>
                        <?php
                        foreach ($packages_info as $row) {
                          echo "<option value=\"{$row['id']}\">{$row['package_name']}</option>";
                        }
                        ?>
                      </select>
                    </div>
                        <input type="hidden" name="package_duration" id="package_duration" />
                  </div>
                  <div class="control-group">
                    <label class="control-label">Package Amount</label>
                    <div class="controls">
                      <div class="input-append">
                        <span class="add-on">₹</span>
                        <input type="number" id="package_amount" name="package_amount" class="span11" readonly>
                      </div>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label">Discount</label>
                    <div class="controls">
                      <div class="input-append">
                        <span class="add-on">₹</span>
                        <input type="number" id="package_discount" name="package_discount" class="span11">
                      </div>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label">Pay Amount</label>
                    <div class="controls">
                      <div class="input-append">
                        <span class="add-on">₹</span>
                        <input type="number" id="pay_amount" name="pay_amount" class="span11">
                      </div>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label">Remaining Amount</label>
                    <div class="controls">
                      <div class="input-append">
                        <span class="add-on">₹</span>
                        <input type="number" id="pending_amount" name="pending_amount" class="span11" readonly>
                      </div>
                    </div>
                  </div>

                  <div class="control-group">
                     <label class="control-label">Payment Method</label>
                     <div class="controls">
                        <select name="payment_mode" required="required">
                              <option value="">Select Payment Method</option>
                              <option value="Card">Card</option>
                              <option value="Cash">Cash</option>
                              <option value="POS">POS</option>
                              <option value="Google Pay">Google Pay</option>
                              <option value="Paytm">Paytm</option>
                              <option value="Amazon Pay">Amazon Pay</option>
                              <option value="Net Banking">Net Banking</option>
                        </select>
                      </div>
                  </div>


                  <div class="form-actions text-center">
                    <button type="submit" class="btn btn-success">Submit Member Details</button>
                  </div>
                  </form>

                </div>



              </div>

            </div>
          </div>

        </div>
      </div>


    </div>
  </div>


  <!--end-main-container-part-->

  <!--Footer-part-->

  <div class="row-fluid">
    <div id="footer" class="span12"> <?php echo date("Y"); ?> &copy; Developed By Naseeb Bajracharya</a> </div>
  </div>

  <style>
    #footer {
      color: white;
    }
  </style>

  <!--end-Footer-part-->

  <script src="../js/excanvas.min.js"></script>
  <script src="../js/jquery.min.js"></script>
  <script src="../js/jquery.ui.custom.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/jquery.flot.min.js"></script>
  <script src="../js/jquery.flot.resize.min.js"></script>
  <script src="../js/jquery.peity.min.js"></script>
  <script src="../js/fullcalendar.min.js"></script>
  <script src="../js/matrix.js"></script>
  <script src="../js/matrix.dashboard.js"></script>
  <script src="../js/jquery.gritter.min.js"></script>
  <script src="../js/matrix.interface.js"></script>
  <script src="../js/matrix.chat.js"></script>
  <script src="../js/jquery.validate.js"></script>
  <script src="../js/matrix.form_validation.js"></script>
  <script src="../js/jquery.wizard.js"></script>
  <script src="../js/jquery.uniform.js"></script>
  <script src="../js/select2.min.js"></script>
  <script src="../js/matrix.popover.js"></script>
  <script src="../js/jquery.dataTables.min.js"></script>
  <script src="../js/matrix.tables.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript">
    var packagesInfo = <?php echo json_encode($packages_info, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;

    $(document).ready(function () {
      $(".package_id").change(function () {
        var selectedPackage = packagesInfo.find(pkg => pkg.id == $(this).val());

        if (selectedPackage) {
          $("#package_amount").val(selectedPackage.package_amount);
          $("#package_duration").val(selectedPackage.package_duration);
        } else {
          $("#package_duration").val(0);
          $("#package_amount").val("");
        }

        calculateBalance();
      });

      $("#pay_amount, #package_amount, #package_discount").on("input", function () {
        calculateBalance();
      });

      function calculateBalance() {
        var packageAmount = parseFloat($("#package_amount").val()) || 0; // Package price
        var discountAmount = parseFloat($("#package_discount").val()) || 0; // Discount
        var payAmount = parseFloat($("#pay_amount").val()) || 0; // Paid amount

        var totalAfterDiscount = packageAmount - discountAmount; // Amount after discount
        var remainingAmount = totalAfterDiscount - payAmount; // Final balance

        $("#pending_amount").val(remainingAmount); // Update pending amount
      }
    });


    // This function is called from the pop-up menus to transfer to
    // a different page. Ignore if the value returned is a null string:
    function goPage(newURL) {

      // if url is empty, skip the menu dividers and reset the menu selection to default
      if (newURL != "") {

        // if url is "-", it is this page -- reset the menu:
        if (newURL == "-") {
          resetMenu();
        }
        // else, send page to designated URL            
        else {
          document.location.href = newURL;
        }
      }
    }

    // resets the menu selection upon entry to this page:
    function resetMenu() {
      document.gomenu.selector.selectedIndex = 2;
    }
  </script>
</body>

</html>