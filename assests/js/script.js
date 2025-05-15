// assets/js/script.js

document.addEventListener('DOMContentLoaded', function() {
    // Konfirmasi sebelum menghapus task
    const deleteLinks = document.querySelectorAll('.btn-danger');
    deleteLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            if (!confirm('Yakin ingin menghapus task ini?')) {
                e.preventDefault();
            }
        });
    });
    
    // Efek hover pada baris tabel
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach(function(row) {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f9f9f9';
        });
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });
    
    // Form validasi
    const forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let valid = true;
            
            requiredFields.forEach(function(field) {
                if (!field.value.trim()) {
                    valid = false;
                    field.style.borderColor = '#e74c3c';
                    
                    // Tambahkan pesan error jika belum ada
                    if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('error-message')) {
                        const errorMessage = document.createElement('p');
                        errorMessage.classList.add('error-message');
                        errorMessage.style.color = '#e74c3c';
                        errorMessage.style.fontSize = '12px';
                        errorMessage.style.marginTop = '5px';
                        errorMessage.textContent = 'Field ini wajib diisi';
                        field.parentNode.insertBefore(errorMessage, field.nextSibling);
                    }
                } else {
                    field.style.borderColor = '';
                    
                    // Hapus pesan error jika ada
                    if (field.nextElementSibling && field.nextElementSibling.classList.contains('error-message')) {
                        field.nextElementSibling.remove();
                    }
                }
            });
            
            if (!valid) {
                e.preventDefault();
            }
        });
    });
    
    // Reset border warna ketika input
    const inputs = document.querySelectorAll('input');
    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            this.style.borderColor = '';
            
            // Hapus pesan error jika ada
            if (this.nextElementSibling && this.nextElementSibling.classList.contains('error-message')) {
                this.nextElementSibling.remove();
            }
        });
    });
});