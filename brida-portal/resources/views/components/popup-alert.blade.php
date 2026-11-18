<!-- SweetAlert2 Global Pop-Up Alert System for BRIDA Kota Makassar -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .swal2-popup {
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif !important;
        border-radius: 1.5rem !important;
        padding: 1.75rem !important;
        border: 1px solid #EBE9E1 !important;
    }
    .swal2-title {
        font-weight: 800 !important;
        color: #0F172A !important;
        font-size: 1.25rem !important;
    }
    .swal2-html-container {
        font-size: 0.85rem !important;
        color: #475569 !important;
        line-height: 1.6 !important;
    }
    .swal2-confirm {
        background-color: #800020 !important;
        border-radius: 0.75rem !important;
        font-weight: 700 !important;
        font-size: 0.75rem !important;
        padding: 0.65rem 1.4rem !important;
        box-shadow: 0 4px 6px -1px rgba(128, 0, 32, 0.2) !important;
    }
    .swal2-cancel {
        background-color: #F1F5F9 !important;
        color: #334155 !important;
        border-radius: 0.75rem !important;
        font-weight: 700 !important;
        font-size: 0.75rem !important;
        padding: 0.65rem 1.4rem !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Pop-up Sukses Otomatis dari Flash Session Laravel
        @php
            $successMsg = session('success') ?? session('success_komentar');
            if (!$successMsg && session('status')) {
                $statusMap = [
                    'profile-updated' => 'Profil akun Anda berhasil diperbarui.',
                    'password-updated' => 'Kata sandi Anda berhasil diperbarui.',
                    'verification-link-sent' => 'Tautan verifikasi baru telah dikirim ke alamat email Anda.',
                ];
                $successMsg = $statusMap[session('status')] ?? session('status');
            }
        @endphp

        @if($successMsg)
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: @json($successMsg),
                confirmButtonText: 'Tutup',
                timer: 4000,
                timerProgressBar: true
            });
        @endif

        // 2. Pop-up Error dari Flash Session
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: @json(session('error')),
                confirmButtonText: 'Mengerti'
            });
        @endif

        // 3. Pop-up Peringatan Validasi Form ($errors)
        @if($errors->any())
            Swal.fire({
                icon: 'warning',
                title: 'Periksa Kembali Isian Anda',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'Perbaiki'
            });
        @endif

        // 4. Handler Global untuk Form dengan Konfirmasi (data-confirm="Pesan...")
        document.querySelectorAll('form[data-confirm]').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                if (form.dataset.confirmed === 'true') return;
                e.preventDefault();

                const message = form.getAttribute('data-confirm') || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
                const title = form.getAttribute('data-confirm-title') || 'Konfirmasi Tindakan';
                const confirmBtn = form.getAttribute('data-confirm-btn') || 'Ya, Lanjutkan';

                Swal.fire({
                    icon: 'question',
                    title: title,
                    text: message,
                    showCancelButton: true,
                    confirmButtonText: confirmBtn,
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.dataset.confirmed = 'true';
                        form.submit();
                    }
                });
            });
        });
    });

    // Helper global untuk memanggil pop-up alert dari tombol/script manapun
    window.showBridaAlert = function(icon, title, text) {
        Swal.fire({
            icon: icon,
            title: title,
            text: text,
            confirmButtonText: 'OK'
        });
    };
</script>
