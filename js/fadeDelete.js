function initDeleteListeners() {
    const forms = document.querySelectorAll("form[action='deleteLeader.php']");
    let activeForm = null;
  
    forms.forEach(form => {
      form.addEventListener("submit", function (e) {
        e.preventDefault(); // STOP default form submission
        activeForm = form;
        showCustomConfirm();
      });
    });
  
    // Confirm delete
    document.getElementById("confirmDeleteBtn").onclick = function () {
      if (activeForm) {
        const row = activeForm.closest("tr");
        row.classList.add("fade-out");
        setTimeout(() => activeForm.submit(), 400);
        hideCustomConfirm();
      }
    };
  
    // Cancel delete
    document.getElementById("cancelDeleteBtn").onclick = hideCustomConfirm;
  }
  
  function showCustomConfirm() {
    document.getElementById("customConfirmModal").classList.add("show");
  }
  
  function hideCustomConfirm() {
    document.getElementById("customConfirmModal").classList.remove("show");
  }
  
  // Run on initial load
  document.addEventListener("DOMContentLoaded", initDeleteListeners);
  