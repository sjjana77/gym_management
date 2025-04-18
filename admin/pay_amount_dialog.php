<?php
include 'getPackages_Info.php';
?>
<div id="customModal" class="modal-overlay">
  <div class="modal-content">
    <span class="close-btn" id="closeModal">&times;</span>
    <h2>Pay Amount</h2>
    <form id="editMemberForm">
      <input type="hidden" id="members_id" name="members_id">
      <input type="hidden" id="transaction_update" name="members_id" value="1">
      <input type="hidden" id="package_data_id" name="package_data_id">
      <div class="form-group">
        <label for="editFullName">Date </label>
        <input type="date" id="date" name="fullname" required>
      </div>
      <div class="form-group">

        <label for="editFullName">package amount </label>
        <div class="input-append">
          <span class="add-on">₹</span>
          <input type="number" id="package_amount" name="package_amount" readonly>
        </div>

      </div>
      <div class="form-group">
        <label for="editFullName">Discount</label>
        <div class="input-append">
          <span class="add-on">₹</span>
          <input type="number" id="package_discount" name="package_discount" readonly>
        </div>
      </div>
      <div class="form-group">
        <label for="editFullName">Amount paid</label>
        <div class="input-append">
          <span class="add-on">₹</span>
          <input type="number" id="amount_paid" name="amount_paid" readonly>
        </div>
      </div>

      <div class="form-group">
        <label for="editFullName">Pay Amount</label>
        <div class="input-append">
          <span class="add-on">₹</span>
          <input type="number" id="cur_pay_amount" name="cur_pay_amount">
        </div>

      </div>

      <div class="form-group">
        <label for="editFullName">Remaining Amount </label>
        <div class="input-append">
          <span class="add-on">₹</span>
          <input type="number" id="cur_pending_amount" name="cur_pending_amount" readonly>
        </div>

      </div>
      <div class="form-group">
        <label for="editGender">Payment Mode</label>
        <select id="payment_mode" name="payment_mode" id="payment_mode" required>
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

      <button type="submit" class="submit-btn">Update Member</button>
    </form>
  </div>
</div>

<!-- Renewal Modal -->
<div id="customModal2" class="modal-overlay">
  <div class="modal-content">
    <span class="close-btn" id="closeModal2">&times;</span>
    <h2>Pay Amount</h2>
    <form id="editMemberForm2">
      <input type="hidden" id="package_data_id" name="package_data_id">
      <input type="hidden" id="package_duration" name="package_duration">

      <!-- Member ID -->
      <div class="form-group">

        <label for="editFullName">Member Id</label>
        <div class="input-append">
          <input type="number" id="members_id" name="members_id" readonly>
        </div>

        <div class="form-group">
          <label for="editFullName">Renewal Start Date </label>
          <input type="date" id="renewal_date" name="date" required>
        </div>


        <div class="form-group">
          <label for="editFullName">Package </label>
          <select name="package_id" class="package_id" required="required" id="select">
            <option value="">Select Package</option>
            <?php
            foreach ($packages_info as $row) {
              echo "<option value=\"{$row['id']}\">{$row['package_name']}</option>";
            }
            ?>
          </select>
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
        <div class="form-group">
          <label for="editGender">Payment Mode</label>
          <select id="payment_mode" name="payment_mode" id="payment_mode" required>
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

        <button type="submit" class="submit-btn">Submit Renewal</button>


    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

  var packagesInfo = <?php echo json_encode($packages_info, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
  $(document).ready(function () {
    $(".package_id").change(function () {
      var selectedPackage = packagesInfo.find(pkg => pkg.id == $(this).val());

      if (selectedPackage) {
        $("#customModal2 #package_amount").val(selectedPackage.package_amount);
        $("#customModal2 #package_duration").val(selectedPackage.package_duration);
      } else {
        $("#customModal2 #package_duration").val(0);
        $("#customModal2 #package_amount").val("");
      }

      calculateBalance();
    });

    $("#customModal2 #pay_amount, #customModal2 #package_amount, #customModal2 #package_discount").on("input", function () {
      calculateBalance();
    });

    function calculateBalance() {
      var packageAmount = parseFloat($("#customModal2 #package_amount").val()) || 0; // Package price
      var discountAmount = parseFloat($("#customModal2 #package_discount").val()) || 0; // Discount
      var payAmount = parseFloat($("#customModal2 #pay_amount").val()) || 0; // Paid amount

      var totalAfterDiscount = packageAmount - discountAmount; // Amount after discount
      var remainingAmount = totalAfterDiscount - payAmount; // Final balance

      $("#customModal2 #pending_amount").val(remainingAmount); // Update pending amount
    }
  });
</script>