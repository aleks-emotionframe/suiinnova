(function() {
    'use strict';

    // Add active class to body
    document.body.classList.add('cms-active');

    // Create save indicator
    var indicator = document.createElement('div');
    indicator.className = 'cms-saving';
    indicator.textContent = 'Speichern...';
    document.body.appendChild(indicator);

    // Create hidden file input
    var fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = 'image/jpeg,image/png,image/webp,image/svg+xml';
    fileInput.className = 'cms-file-input';
    document.body.appendChild(fileInput);

    var currentImageEl = null;

    // Show indicator
    function showIndicator(text, type) {
        indicator.textContent = text;
        indicator.className = 'cms-saving is-visible' + (type ? ' is-' + type : '');
        if (type) {
            setTimeout(function() { indicator.className = 'cms-saving'; }, 2500);
        }
    }

    // Save content via AJAX
    function saveContent(id, field, value) {
        showIndicator('Speichern...');

        var formData = new FormData();
        formData.append('id', id);
        formData.append('field', field);
        formData.append('value', value);

        fetch('/admin/api/save', {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                showIndicator('Gespeichert', 'success');
            } else {
                showIndicator('Fehler: ' + (data.error || 'Unbekannt'), 'error');
            }
        })
        .catch(function() {
            showIndicator('Verbindungsfehler', 'error');
        });
    }

    // Upload image via AJAX
    function uploadImage(id, file) {
        showIndicator('Bild wird hochgeladen...');

        var formData = new FormData();
        formData.append('id', id);
        formData.append('image', file);

        fetch('/admin/api/upload', {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success && data.url) {
                if (currentImageEl) {
                    currentImageEl.src = data.url;
                }
                showIndicator('Bild gespeichert', 'success');
            } else {
                showIndicator('Fehler: ' + (data.error || 'Upload fehlgeschlagen'), 'error');
            }
        })
        .catch(function() {
            showIndicator('Verbindungsfehler', 'error');
        });
    }

    // Handle file input change
    fileInput.addEventListener('change', function() {
        if (fileInput.files.length > 0 && currentImageEl) {
            var id = currentImageEl.getAttribute('data-cms-id');
            uploadImage(id, fileInput.files[0]);
        }
        fileInput.value = '';
    });

    // Handle clicks on editable elements
    document.addEventListener('click', function(e) {
        // Check for image behind overlay (fullwidth-banner, hero)
        var overlay = e.target.closest('.fullwidth-banner-overlay, .fullwidth-banner-content, .hero-overlay');
        if (overlay) {
            var section = overlay.closest('.fullwidth-banner, .hero-bg');
            if (section) {
                var img = section.querySelector('img[data-cms-id]');
                if (img) {
                    e.preventDefault();
                    e.stopPropagation();
                    currentImageEl = img;
                    fileInput.click();
                    return;
                }
            }
        }

        var el = e.target.closest('[data-cms-id]');
        if (!el) return;

        var field = el.getAttribute('data-cms-field');
        var id = el.getAttribute('data-cms-id');

        // Image fields: open file picker
        if (field === 'image_path') {
            e.preventDefault();
            e.stopPropagation();
            currentImageEl = el;
            fileInput.click();
            return;
        }

        // Text fields: make contenteditable
        if (el.getAttribute('contenteditable') === 'true') return;

        e.preventDefault();
        e.stopPropagation();

        el.setAttribute('contenteditable', 'true');
        el.classList.add('cms-editing');
        el.focus();

        function onBlur() {
            el.removeAttribute('contenteditable');
            el.classList.remove('cms-editing');
            el.removeEventListener('blur', onBlur);
            el.removeEventListener('keydown', onKeydown);

            var newValue = el.innerText.trim();
            saveContent(id, field, newValue);
        }

        function onKeydown(ev) {
            if (ev.key === 'Escape') {
                el.blur();
            }
        }

        el.addEventListener('blur', onBlur);
        el.addEventListener('keydown', onKeydown);
    });

})();
