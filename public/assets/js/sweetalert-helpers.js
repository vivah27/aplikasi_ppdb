/**
 * SweetAlert2 Helper Functions
 * Digunakan untuk mengganti confirm() dialog dengan SweetAlert2
 */

// Get CSRF token dari meta tag
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content || 
           document.querySelector('input[name="_token"]')?.value || '';
}

// Delete confirmation with SweetAlert2
function confirmDelete(action, csrfToken, messageOverride = null, relatedCount = null) {
    let message = messageOverride || 'Yakin ingin menghapus?';
    
    if (relatedCount && relatedCount > 0) {
        message = `Yakin ingin menghapus? ${relatedCount} dokumen terkait juga akan dihapus.`;
    }

    // Use provided token or get from meta
    const token = csrfToken || getCsrfToken();

    Swal.fire({
        title: 'Konfirmasi Hapus',
        html: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: false
    }).then((result) => {
        if (result.isConfirmed) {
            // Create and submit form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = action;
            form.innerHTML = `
                <input type="hidden" name="_token" value="${token}">
                <input type="hidden" name="_method" value="DELETE">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Accept confirmation
function confirmAccept(action, csrfToken, itemName = null) {
    const message = itemName ? `Apakah Anda yakin ingin <strong>menerima</strong> ${itemName}?` : 'Apakah Anda yakin ingin menerima?';
    
    // Use provided token or get from meta
    const token = csrfToken || getCsrfToken();
    
    Swal.fire({
        title: 'Konfirmasi Terima',
        html: message,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Terima',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Use AJAX instead of form submission
            fetch(action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 419) {
                        Swal.fire('Session Expired', 'Silakan refresh halaman dan login ulang', 'error');
                        return;
                    }
                    throw new Error('Request failed');
                }
                return response.json();
            })
            .then(data => {
                Swal.fire('Berhasil!', 'Dokumen berhasil diterima', 'success').then(() => {
                    location.reload();
                });
            })
            .catch(error => {
                Swal.fire('Error', 'Terjadi kesalahan saat memproses', 'error');
                console.error('Error:', error);
            });
        }
    });
}

// Reject confirmation
function confirmReject(action, csrfToken, itemName = null) {
    const message = itemName ? `Apakah Anda yakin ingin <strong>menolak</strong> ${itemName}?` : 'Apakah Anda yakin ingin menolak?';
    
    // Use provided token or get from meta
    const token = csrfToken || getCsrfToken();
    
    Swal.fire({
        title: 'Konfirmasi Tolak',
        html: message,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Tolak',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Use AJAX instead of form submission
            fetch(action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    catatan: 'Ditolak oleh admin (quick action)'
                })
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 419) {
                        Swal.fire('Session Expired', 'Silakan refresh halaman dan login ulang', 'error');
                        return;
                    }
                    throw new Error('Request failed');
                }
                return response.json();
            })
            .then(data => {
                Swal.fire('Berhasil!', 'Dokumen berhasil ditolak', 'success').then(() => {
                    location.reload();
                });
            })
            .catch(error => {
                Swal.fire('Error', 'Terjadi kesalahan saat memproses', 'error');
                console.error('Error:', error);
            });
        }
    });
}

// Show success message
function showSuccess(message = 'Berhasil!', timer = 3000) {
    Swal.fire({
        icon: 'success',
        title: 'Sukses',
        text: message,
        timer: timer,
        timerProgressBar: true,
        showConfirmButton: false
    });
}

// Show error message
function showError(message = 'Terjadi kesalahan!') {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message,
        confirmButtonColor: '#ef4444'
    });
}

// Show info message
function showInfo(message = 'Informasi') {
    Swal.fire({
        icon: 'info',
        title: 'Informasi',
        text: message,
        confirmButtonColor: '#6366f1'
    });
}

// Show warning message
function showWarning(message = 'Perhatian!') {
    Swal.fire({
        icon: 'warning',
        title: 'Peringatan',
        text: message,
        confirmButtonColor: '#f59e0b'
    });
}

// Initialize delete buttons
document.addEventListener('DOMContentLoaded', function() {
    // For generic delete buttons with data attributes
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const action = this.dataset.action;
            const csrf = this.dataset.csrf;
            confirmDelete(action, csrf);
        });
    });

    // For delete buttons with special styling (admin pages)
    document.querySelectorAll('.btn-delete-swal').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const action = this.dataset.action;
            const csrf = this.dataset.csrf;
            const relatedCount = this.dataset.related || 0;
            confirmDelete(action, csrf, null, relatedCount);
        });
    });

    // For accept buttons
    document.querySelectorAll('.btn-verify-accept').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const action = this.dataset.action || this.closest('form')?.action;
            const csrf = this.dataset.csrf || document.querySelector('meta[name="csrf-token"]')?.content;
            const itemName = this.dataset.itemName || 'dokumen ini';
            confirmAccept(action, csrf, itemName);
        });
    });

    // For reject buttons
    document.querySelectorAll('.btn-verify-reject').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const action = this.dataset.action || this.closest('form')?.action;
            const csrf = this.dataset.csrf || document.querySelector('meta[name="csrf-token"]')?.content;
            const itemName = this.dataset.itemName || 'dokumen ini';
            confirmReject(action, csrf, itemName);
        });
    });
});
