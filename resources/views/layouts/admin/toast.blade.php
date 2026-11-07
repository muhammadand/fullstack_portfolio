{{--
    Standar notifikasi admin (SweetAlert2).

    Toast kecil yang turun dari atas (gaya aplikasi dompet digital):
      - Otomatis dari flash session: ->with('success'|'error'|'warning'|'info'|'status', '...')
      - Dari JS:        toast('success', 'Tersimpan')
      - Dari Livewire:  $this->dispatch('toast', type: 'success', message: 'Tersimpan')

    Konfirmasi:
      - Form:  <form ... data-confirm="Hapus data ini?" data-confirm-danger>
               (atau di satu tombol submit: <button name="x" value="y" data-confirm="...">)
      - JS:    if (await confirmDialog({ title: 'Hapus?', text: '...', danger: true })) { ... }
--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.14.5/sweetalert2.all.min.js" data-navigate-once></script>
<style>
    /* Toast: pil putih kecil di tengah atas, masuk dengan slide dari atas. */
    .swal2-container.admin-toast-container { padding: 14px 12px 0; }
    .swal2-popup.admin-toast {
        width: max-content !important; max-width: min(92vw, 440px) !important; min-width: 0;
        padding: 10px 16px 10px 10px !important; border-radius: 999px !important;
        background: #fff; box-shadow: 0 10px 30px -8px rgba(15, 23, 42, .25), 0 0 0 1px rgba(15, 23, 42, .06) !important;
        display: flex !important; align-items: center; gap: 10px; grid-template-columns: none !important;
    }
    .swal2-popup.admin-toast .swal2-html-container { margin: 0 !important; padding: 0 !important; overflow: visible; text-align: left; }
    .admin-toast-body { display: flex; align-items: center; gap: 10px; font: 500 13px/1.35 Inter, sans-serif; color: #0f172a; }
    .admin-toast-icon { width: 26px; height: 26px; border-radius: 999px; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 12px; color: #fff; }
    .admin-toast-icon.success { background: #10b981; }
    .admin-toast-icon.error   { background: #ef4444; }
    .admin-toast-icon.warning { background: #f59e0b; }
    .admin-toast-icon.info    { background: #3b82f6; }
    .admin-toast-in  { animation: adminToastIn .38s cubic-bezier(.21, 1.02, .73, 1) both; }
    .admin-toast-out { animation: adminToastOut .25s ease-in both; }
    @keyframes adminToastIn  { from { transform: translateY(-120%); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    @keyframes adminToastOut { from { transform: translateY(0); opacity: 1; } to { transform: translateY(-120%); opacity: 0; } }

    /* Dialog konfirmasi: senada dengan komponen admin (rounded, Inter, tombol biru/merah). */
    .swal2-popup.admin-dialog { border-radius: 16px !important; padding: 22px 20px 18px !important; width: min(92vw, 380px) !important; font-family: Inter, sans-serif; }
    .swal2-popup.admin-dialog .swal2-title { font-size: 17px; font-weight: 600; color: #0f172a; padding: 0; }
    .swal2-popup.admin-dialog .swal2-html-container { font-size: 13.5px; color: #475569; margin: 8px 0 0; }
    .swal2-popup.admin-dialog .swal2-icon { transform: scale(.7); margin: 0 auto -6px; }
    .swal2-popup.admin-dialog .swal2-actions { gap: 8px; margin-top: 18px; width: 100%; flex-wrap: nowrap; }
    .admin-dialog-btn { flex: 1; padding: 10px 14px; border-radius: 10px; font: 600 13.5px Inter, sans-serif; border: 0; cursor: pointer; }
    .admin-dialog-btn.primary { background: #2563eb; color: #fff; }
    .admin-dialog-btn.danger  { background: #dc2626; color: #fff; }
    .admin-dialog-btn.cancel  { background: #f1f5f9; color: #334155; }
</style>
<script data-navigate-once>
    (function () {
        const ICONS = { success: 'fa-check', error: 'fa-xmark', warning: 'fa-exclamation', info: 'fa-info' };
        const escapeHtml = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

        window.toast = function (type, message, options = {}) {
            if (!message) return;
            type = ICONS[type] ? type : 'info';
            if (typeof Swal === 'undefined') { console[type === 'error' ? 'error' : 'log'](message); return; }

            Swal.fire({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: options.timer ?? (type === 'error' || type === 'warning' ? 5000 : 3000),
                html: `<div class="admin-toast-body" role="${type === 'error' ? 'alert' : 'status'}"><span class="admin-toast-icon ${type}"><i class="fa-solid ${ICONS[type]}"></i></span><span>${escapeHtml(message)}</span></div>`,
                customClass: { container: 'admin-toast-container', popup: 'admin-toast' },
                showClass: { popup: 'admin-toast-in' },
                hideClass: { popup: 'admin-toast-out' },
                didOpen: (el) => {
                    el.addEventListener('mouseenter', Swal.stopTimer);
                    el.addEventListener('mouseleave', Swal.resumeTimer);
                    el.addEventListener('click', () => Swal.close());
                },
            });
        };

        window.confirmDialog = async function ({ title = 'Yakin?', text = '', confirmText = 'Ya, lanjutkan', cancelText = 'Batal', danger = false } = {}) {
            if (typeof Swal === 'undefined') return window.confirm(text || title);

            const result = await Swal.fire({
                title, text,
                icon: danger ? 'warning' : 'question',
                showCancelButton: true,
                confirmButtonText: confirmText,
                cancelButtonText: cancelText,
                reverseButtons: true,
                focusCancel: danger,
                buttonsStyling: false,
                customClass: { popup: 'admin-dialog', confirmButton: `admin-dialog-btn ${danger ? 'danger' : 'primary'}`, cancelButton: 'admin-dialog-btn cancel' },
            });
            return result.isConfirmed;
        };

        // <form data-confirm="..."> : tahan submit sampai dikonfirmasi lewat dialog.
        document.addEventListener('submit', async (e) => {
            const form = e.target;
            const submitter = e.submitter;
            // data-confirm boleh di <form> atau di tombol submit tertentu (mis. hanya tombol "Production").
            const src = submitter?.dataset?.confirm ? submitter : form;
            if (!(form instanceof HTMLFormElement) || !src.dataset.confirm || form.dataset.confirmed === '1') return;
            e.preventDefault();
            const danger = src.hasAttribute('data-confirm-danger');
            const ok = await confirmDialog({
                title: src.dataset.confirmTitle || 'Konfirmasi',
                text: src.dataset.confirm,
                confirmText: src.dataset.confirmButton || (danger ? 'Ya, hapus' : 'Ya, lanjutkan'),
                danger,
            });
            if (!ok) return;
            form.dataset.confirmed = '1';
            form.requestSubmit(submitter || undefined);
            delete form.dataset.confirmed;
        }, true);

        // Livewire: $this->dispatch('toast', type: 'success', message: '...')
        window.addEventListener('toast', (e) => {
            const d = Array.isArray(e.detail) ? e.detail[0] : e.detail;
            if (d) toast(d.type, d.message);
        });
    })();
</script>
@php
    $flashToasts = collect(['success' => 'success', 'status' => 'success', 'error' => 'error', 'warning' => 'warning', 'info' => 'info'])
        ->map(fn ($type, $key) => session()->has($key) && is_string(session($key)) ? ['type' => $type, 'message' => session($key)] : null)
        ->filter()->values();
@endphp
@if($flashToasts->isNotEmpty())
<script>
    // Flash dari redirect: tampilkan berurutan agar tidak saling menimpa.
    (function show(queue) {
        if (typeof window.toast !== 'function' || typeof Swal === 'undefined') { return setTimeout(() => show(queue), 50); }
        const next = queue.shift();
        if (!next) return;
        toast(next.type, next.message);
        if (queue.length) setTimeout(() => show(queue), next.type === 'error' ? 5200 : 3200);
    })(@js($flashToasts));
</script>
@endif
