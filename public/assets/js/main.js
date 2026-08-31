/* ============================================================
   TechnoMeits Store - main JavaScript (kept minimal)
   ============================================================ */

// Auto-dismiss alerts after a few seconds
document.querySelectorAll('.alert').forEach(function (alert) {
    setTimeout(function () {
        var close = bootstrap.Alert.getOrCreateInstance(alert);
        close.close();
    }, 5000);
});

// Confirm dialog for destructive actions
document.querySelectorAll('form[data-confirm]').forEach(function (form) {
    form.addEventListener('submit', function (event) {
        var message = form.getAttribute('data-confirm') || 'Are you sure?';
        if (!window.confirm(message)) {
            event.preventDefault();
        }
    });
});
