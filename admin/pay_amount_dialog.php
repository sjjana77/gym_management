  <div id="customModal" class="modal-overlay">
    <div class="modal-content">
      <span class="close-btn" id="closeModal">&times;</span>
      <h2>Pay Amount</h2>
      <form id="editMemberForm">
        <input type="hidden" id="members_id" name="members_id">
        <input type="hidden" id="package_data_id" name="package_data_id">
        <div class="form-group">
          <label for="editFullName">Date </label>
          <input type="date" id="date" name="fullname" required>
        </div>
        <div class="form-group">

          <label for="editFullName">package amount </label>
          <div class="input-append">
            <span class="add-on">₹</span>
            <input type="number" id="package_amount" name="package_amount" value="2000" readonly>
          </div>

        </div>
        <div class="form-group">
          <label for="editFullName">Discount</label>
          <div class="input-append">
            <span class="add-on">₹</span>
            <input type="number" id="package_discount" name="package_discount" value="20" readonly>
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