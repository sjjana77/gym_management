$(document).ready(function () {
    $("#cur_pay_amount").on("input", function () {
        let packageAmount = parseFloat($("#package_amount").val()) || 0;
        let discount = parseFloat($("#package_discount").val()) || 0;
        let amountPaid = parseFloat($("#amount_paid").val()) || 0;
        let payAmount = parseFloat($(this).val()) || 0;

        let remainingAmount = (packageAmount - discount) - (amountPaid + payAmount);
        $("#cur_pending_amount").val(remainingAmount);
    });

});

document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("customModal");
    const closeModal = document.getElementById("closeModal");
    const dateInput = document.getElementById("date");

    let today = new Date().toISOString().split('T')[0];
    dateInput.value = today;
    document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            document.getElementById("members_id").value = this.dataset.id;
            document.getElementById("package_data_id").value = this.dataset.package_data_id;
            document.getElementById("package_amount").value = this.dataset.package_amount;
            document.getElementById("package_discount").value = this.dataset.package_discount;
            document.getElementById("amount_paid").value = this.dataset.amount_paid;
            document.getElementById("cur_pay_amount").value = this.dataset.cur_pending_amount;
            document.getElementById("cur_pending_amount").value = 0;
            document.getElementById("payment_mode").value = "";

            dateInput.value = new Date().toISOString().split('T')[0];

            modal.style.display = "flex"; // Show modal
        });
    });

    closeModal.addEventListener("click", function () {
        modal.style.display = "none"; // Hide modal
    });

    document.getElementById("editMemberForm").addEventListener("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        fetch("actions/transaction-entry.php", {
            method: "POST",
            body: formData,
        })
            .then(response => response.text())
            .then(data => {
                alert("Transaction Successfull!");
                modal.style.display = "none";
                location.reload();
            })
            .catch(error => {
                alert("Error updating member.");
            });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("customModal2");
    const closeModal = document.getElementById("closeModal2");
    const dateInput = document.getElementById("date");

    let today = new Date().toISOString().split('T')[0];
    dateInput.value = today;
    document.querySelectorAll(".renewal-btn").forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            // document.getElementById("members_id").value = this.dataset.id;

            dateInput.value = new Date().toISOString().split('T')[0];

            modal.style.display = "flex"; // Show modal
        });
    });

    closeModal.addEventListener("click", function () {
        modal.style.display = "none"; // Hide modal
    });

    document.getElementById("editMemberForm2").addEventListener("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        fetch("actions/transaction-entry.php", {
            method: "POST",
            body: formData,
        })
            .then(response => response.text())
            .then(data => {
                alert("Transaction Successfull!");
                modal.style.display = "none";
                location.reload();
            })
            .catch(error => {
                alert("Error updating member.");
            });
    });
});