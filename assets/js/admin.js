/**
 * SUI Innova GmbH — Admin JavaScript
 */
(function () {
    'use strict';

    // --- Sidebar toggle (mobile) ---
    var toggle = document.getElementById('sidebar-toggle');
    var sidebar = document.getElementById('admin-sidebar');
    if (toggle && sidebar) {
        toggle.addEventListener('click', function () {
            sidebar.classList.toggle('is-open');
        });

        // Close when clicking outside
        document.addEventListener('click', function (e) {
            if (sidebar.classList.contains('is-open') &&
                !sidebar.contains(e.target) &&
                !toggle.contains(e.target)) {
                sidebar.classList.remove('is-open');
            }
        });
    }

    // --- Auto-dismiss alerts ---
    var alerts = document.querySelectorAll('.alert-success');
    alerts.forEach(function (alert) {
        setTimeout(function () {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(function () { alert.remove(); }, 500);
        }, 4000);
    });

})();
