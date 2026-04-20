/**
 * SUI Innova GmbH — Admin CMS JavaScript
 *
 * Alpine.js Komponenten fuer den Admin-Bereich.
 */

// =============================================
// Rich Text Editor (contenteditable mit Toolbar)
// =============================================
function richEditor() {
    return {
        editorEl: null,
        hiddenEl: null,

        initEditor(editor, hidden) {
            this.editorEl = editor;
            this.hiddenEl = hidden;
        },

        execCmd(command) {
            document.execCommand(command, false, null);
            this.editorEl?.focus();
            this.syncToHidden(this.editorEl, this.hiddenEl);
        },

        addLink() {
            const url = prompt('URL eingeben:');
            if (url) {
                document.execCommand('createLink', false, url);
                this.editorEl?.focus();
                this.syncToHidden(this.editorEl, this.hiddenEl);
            }
        },

        syncToHidden(editor, hidden) {
            if (editor && hidden) {
                hidden.value = editor.innerHTML;
            }
        },
    };
}

// =============================================
// Page Editor
// =============================================
function pageEditor() {
    return {
        toast: false,
        toastMessage: '',
        toastType: 'success',

        init() {
            // Drag & Drop Sortierung
            const list = document.getElementById('sections-list');
            if (list && typeof Sortable !== 'undefined') {
                Sortable.create(list, {
                    handle: '.drag-handle',
                    animation: 200,
                    ghostClass: 'opacity-30',
                    onEnd: async () => {
                        const order = [...list.querySelectorAll('[data-section-id]')]
                            .map(el => parseInt(el.dataset.sectionId));

                        try {
                            await fetch('/admin/api/reorder-sections.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': CSRF_TOKEN,
                                },
                                body: JSON.stringify({ order, csrf_token: CSRF_TOKEN }),
                            });
                            this.showToast('Reihenfolge gespeichert', 'success');
                        } catch (err) {
                            this.showToast('Fehler beim Sortieren', 'error');
                        }
                    },
                });
            }
        },

        async saveSection(sectionId, form) {
            const formData = new FormData(form);
            formData.append('section_id', sectionId);
            formData.append('csrf_token', CSRF_TOKEN);

            try {
                const resp = await fetch('/admin/api/save-section.php', {
                    method: 'POST',
                    body: formData,
                });
                const data = await resp.json();

                if (data.success) {
                    this.showToast('Sektion gespeichert', 'success');
                } else {
                    this.showToast(data.error || 'Fehler beim Speichern', 'error');
                }
            } catch (err) {
                this.showToast('Netzwerkfehler', 'error');
            }
        },

        async savePageMeta(pageId, field, value) {
            const formData = new FormData();
            formData.append('page_id', pageId);
            formData.append('field', field);
            formData.append('value', value);
            formData.append('csrf_token', CSRF_TOKEN);

            try {
                const resp = await fetch('/admin/api/save-page-meta.php', {
                    method: 'POST',
                    body: formData,
                });
                const data = await resp.json();
                if (data.success) {
                    this.showToast('Gespeichert', 'success');
                }
            } catch (err) {
                // Silently fail for meta saves
            }
        },

        async deleteSection(sectionId) {
            if (!confirm('Diese Sektion wirklich löschen?')) return;

            const formData = new FormData();
            formData.append('section_id', sectionId);
            formData.append('csrf_token', CSRF_TOKEN);

            try {
                const resp = await fetch('/admin/api/delete-section.php', {
                    method: 'POST',
                    body: formData,
                });
                const data = await resp.json();
                if (data.success) {
                    // Remove from DOM
                    const card = document.querySelector(`[data-section-id="${sectionId}"]`);
                    if (card) card.remove();
                    this.showToast('Sektion gelöscht', 'success');
                }
            } catch (err) {
                this.showToast('Fehler beim Löschen', 'error');
            }
        },

        async addSection(pageId, type) {
            const formData = new FormData();
            formData.append('page_id', pageId);
            formData.append('type', type);
            formData.append('csrf_token', CSRF_TOKEN);

            try {
                const resp = await fetch('/admin/api/add-section.php', {
                    method: 'POST',
                    body: formData,
                });
                const data = await resp.json();
                if (data.success) {
                    // Reload page to show new section
                    window.location.reload();
                }
            } catch (err) {
                this.showToast('Fehler beim Hinzufügen', 'error');
            }
        },

        openMediaPicker(fieldKey) {
            // Deprecated - now handled by mediaField() component
        },

        showToast(message, type = 'success') {
            this.toastMessage = message;
            this.toastType = type;
            this.toast = true;
            setTimeout(() => { this.toast = false; }, 3000);
        },
    };
}

// =============================================
// Repeater Field
// =============================================
function repeaterField(initialItems) {
    return {
        items: Array.isArray(initialItems) ? [...initialItems] : [],

        addItem() {
            // Add empty item with same keys as first item (or empty)
            if (this.items.length > 0) {
                const template = {};
                Object.keys(this.items[0]).forEach(key => { template[key] = ''; });
                this.items.push(template);
            } else {
                this.items.push({});
            }
        },

        removeItem(index) {
            this.items.splice(index, 1);
        },
    };
}

// =============================================
// Global Media Picker (Modal)
// =============================================
let _mediaPickerCallback = null;

function mediaPicker() {
    return {
        isOpen: false,
        items: [],
        loading: false,
        uploading: false,
        selectedId: null,
        selectedItem: null,

        init() {
            // Global open event
            window.openMediaPicker = (callback) => {
                _mediaPickerCallback = callback;
                this.selectedId = null;
                this.selectedItem = null;
                this.isOpen = true;
                this.loadMedia();
            };
        },

        async loadMedia() {
            this.loading = true;
            try {
                const resp = await fetch('/admin/api/list-media.php');
                this.items = await resp.json();
            } catch (err) {
                this.items = [];
            }
            this.loading = false;
        },

        select(item) {
            this.selectedId = item.id;
            this.selectedItem = item;
        },

        confirm() {
            if (this.selectedId && _mediaPickerCallback) {
                _mediaPickerCallback(this.selectedItem);
            }
            this.close();
        },

        close() {
            this.isOpen = false;
            _mediaPickerCallback = null;
        },

        async uploadNew(event) {
            const file = event.target.files?.[0];
            if (!file) return;
            event.target.value = '';

            this.uploading = true;
            const formData = new FormData();
            formData.append('file', file);
            formData.append('csrf_token', CSRF_TOKEN);

            try {
                const resp = await fetch('/admin/api/upload-media.php', { method: 'POST', body: formData });
                const data = await resp.json();
                if (data.success) {
                    await this.loadMedia();
                    // Auto-select the new upload
                    if (data.media) {
                        this.selectedId = data.media.id;
                        this.selectedItem = {
                            id: data.media.id,
                            original: data.media.original,
                            url: data.media.url,
                            thumb_url: data.media.thumb_url || data.media.url,
                        };
                    }
                } else {
                    alert(data.error || 'Upload fehlgeschlagen');
                }
            } catch (err) {
                alert('Upload fehlgeschlagen');
            }
            this.uploading = false;
        },
    };
}

// =============================================
// Media Manager
// =============================================
function mediaManager() {
    return {
        dragOver: false,
        uploading: false,
        toast: false,
        toastMessage: '',
        toastType: 'success',

        async handleDrop(event) {
            this.dragOver = false;
            const files = event.dataTransfer.files;
            await this.uploadFiles(files);
        },

        async handleFileSelect(event) {
            const files = event.target.files;
            await this.uploadFiles(files);
            event.target.value = ''; // Reset input
        },

        async uploadFiles(files) {
            this.uploading = true;

            for (const file of files) {
                const formData = new FormData();
                formData.append('file', file);
                formData.append('csrf_token', typeof CSRF_TOKEN !== 'undefined' ? CSRF_TOKEN : '');

                try {
                    const resp = await fetch('/admin/api/upload-media.php', {
                        method: 'POST',
                        body: formData,
                    });
                    const data = await resp.json();

                    if (data.success) {
                        this.showToast(file.name + ' hochgeladen', 'success');
                    } else {
                        this.showToast(data.error || 'Upload fehlgeschlagen', 'error');
                    }
                } catch (err) {
                    this.showToast('Netzwerkfehler bei ' + file.name, 'error');
                }
            }

            this.uploading = false;
            // Reload to show new media
            setTimeout(() => window.location.reload(), 500);
        },

        async deleteMedia(mediaId) {
            if (!confirm('Dieses Medium wirklich löschen?')) return;

            const formData = new FormData();
            formData.append('media_id', mediaId);
            formData.append('csrf_token', typeof CSRF_TOKEN !== 'undefined' ? CSRF_TOKEN : '');

            try {
                const resp = await fetch('/admin/api/delete-media.php', {
                    method: 'POST',
                    body: formData,
                });
                const data = await resp.json();
                if (data.success) {
                    window.location.reload();
                }
            } catch (err) {
                this.showToast('Fehler beim Löschen', 'error');
            }
        },

        showToast(message, type = 'success') {
            this.toastMessage = message;
            this.toastType = type;
            this.toast = true;
            setTimeout(() => { this.toast = false; }, 3000);
        },
    };
}

// =============================================
// Settings Manager
// =============================================
function settingsManager() {
    return {
        saving: false,
        toast: false,
        toastMessage: '',
        toastType: 'success',

        async saveSettings(form) {
            this.saving = true;
            const formData = new FormData(form);
            formData.append('csrf_token', typeof CSRF_TOKEN !== 'undefined' ? CSRF_TOKEN : '');

            try {
                const resp = await fetch('/admin/api/save-settings.php', {
                    method: 'POST',
                    body: formData,
                });
                const data = await resp.json();

                if (data.success) {
                    this.showToast('Einstellungen gespeichert', 'success');
                } else {
                    this.showToast(data.error || 'Fehler', 'error');
                }
            } catch (err) {
                this.showToast('Netzwerkfehler', 'error');
            }

            this.saving = false;
        },

        showToast(message, type = 'success') {
            this.toastMessage = message;
            this.toastType = type;
            this.toast = true;
            setTimeout(() => { this.toast = false; }, 3000);
        },
    };
}

// =============================================
// Contacts Manager
// =============================================
function contactsManager() {
    return {
        async markAsRead(contactId) {
            const formData = new FormData();
            formData.append('contact_id', contactId);
            formData.append('csrf_token', typeof CSRF_TOKEN !== 'undefined' ? CSRF_TOKEN : '');

            try {
                await fetch('/admin/api/mark-contact-read.php', {
                    method: 'POST',
                    body: formData,
                });
            } catch (err) {
                // Silent
            }
        },
    };
}

// =============================================
// Media Field (with Picker + Upload)
// =============================================
function mediaField(initialId, fieldName, initialThumb) {
    return {
        mediaId: initialId || 0,
        fieldName: fieldName,
        thumbUrl: initialThumb || '',

        openPicker() {
            window.openMediaPicker((item) => {
                this.mediaId = item.id;
                this.thumbUrl = item.thumb_url || item.url;
            });
        },

        removeMedia() {
            this.mediaId = 0;
            this.thumbUrl = '';
        },
    };
}
