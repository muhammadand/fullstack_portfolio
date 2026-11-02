<script>
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        // Base styles
        toast.className = 'fixed top-10 left-1/2 -translate-x-1/2 px-5 py-3 rounded-full shadow-2xl z-[80] flex items-center gap-3 text-sm font-medium transition-all duration-500 transform -translate-y-10 opacity-0 min-w-[280px] max-w-[90vw] justify-center';

        if (type === 'success') {
            toast.classList.add('bg-slate-800', 'border', 'border-emerald-500/30', 'text-white');
            toast.innerHTML = `<div class="w-6 h-6 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400 shrink-0"><i class="fa-solid fa-check text-xs"></i></div> <span class="truncate">${message}</span>`;
        } else {
            toast.classList.add('bg-slate-800', 'border', 'border-red-500/30', 'text-white');
            toast.innerHTML = `<div class="w-6 h-6 rounded-full bg-red-500/20 flex items-center justify-center text-red-400 shrink-0"><i class="fa-solid fa-xmark text-xs"></i></div> <span class="truncate">${message}</span>`;
        }

        document.body.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.classList.remove('-translate-y-10', 'opacity-0');
        }, 10);

        // Animate out
        setTimeout(() => {
            toast.classList.add('-translate-y-10', 'opacity-0');
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }

    function copyLink() {
        var copyText = document.getElementById("affiliate-link");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);

        showToast('Link website berhasil disalin!', 'success');
    }

    function copyLoginLink() {
        var copyText = document.getElementById("login-link-input");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);

        showToast('Link Akses Login berhasil disalin!', 'success');
    }

    function openWithdrawModal() {
        const modal = document.getElementById('withdrawModal');
        const content = document.getElementById('withdrawModalContent');

        modal.classList.remove('opacity-0', 'pointer-events-none');
        // Bottom sheet slide up animation
        setTimeout(() => {
            content.classList.remove('translate-y-full');
        }, 10);
    }

    function closeWithdrawModal() {
        const modal = document.getElementById('withdrawModal');
        const content = document.getElementById('withdrawModalContent');

        content.classList.add('translate-y-full');
        setTimeout(() => {
            modal.classList.add('opacity-0', 'pointer-events-none');
        }, 300);
    }

    function openNotificationModal() {
        const modal = document.getElementById('notificationModal');
        const content = document.getElementById('notificationModalContent');

        modal.classList.remove('opacity-0', 'pointer-events-none');
        setTimeout(() => {
            content.classList.remove('translate-y-full');
        }, 10);
    }

    function closeNotificationModal() {
        const modal = document.getElementById('notificationModal');
        const content = document.getElementById('notificationModalContent');

        content.classList.add('translate-y-full');
        setTimeout(() => {
            modal.classList.add('opacity-0', 'pointer-events-none');
        }, 300);
    }

    function openWalletDepositModal() {
        const modal = document.getElementById('walletDepositModal');
        const content = document.getElementById('walletDepositModalContent');
        if (!modal || !content) return;

        modal.classList.remove('opacity-0', 'pointer-events-none');
        setTimeout(() => {
            content.classList.remove('translate-y-full');
        }, 10);

        // Pastikan chip yang sesuai dengan input aktif secara visual saat modal dibuka
        const input = document.getElementById('deposit_amount_input');
        const initialAmount = input ? (parseFloat(input.value) || 50000) : 50000;
        updateDepositChipState(initialAmount);
    }

    function closeWalletDepositModal() {
        const modal = document.getElementById('walletDepositModal');
        const content = document.getElementById('walletDepositModalContent');
        if (!modal || !content) return;

        content.classList.add('translate-y-full');
        setTimeout(() => {
            modal.classList.add('opacity-0', 'pointer-events-none');
        }, 300);
    }

    function setDepositAmount(amount, btn = null) {
        const input = document.getElementById('deposit_amount_input');
        if (input) {
            input.value = amount;
            updateDepositChipState(amount, btn);
            calculateDepositLive(false);
        }
    }

    function updateDepositChipState(amount, selectedBtn = null) {
        const chips = document.querySelectorAll('.deposit-chip');
        chips.forEach(chip => {
            const chipAmount = parseFloat(chip.getAttribute('data-amount')) || 0;
            const isMatch = (selectedBtn && chip === selectedBtn) || (!selectedBtn && chipAmount === parseFloat(amount));

            if (isMatch) {
                chip.className = 'deposit-chip py-2 px-1.5 rounded-xl border border-emerald-500 bg-emerald-500/20 text-emerald-300 ring-1 ring-emerald-500/50 shadow-[0_0_12px_rgba(16,185,129,0.25)] text-xs font-extrabold transition-all duration-150 text-center active:scale-95 cursor-pointer';
            } else {
                chip.className = 'deposit-chip py-2 px-1.5 rounded-xl border border-white/10 glass-panel hover:border-emerald-500/40 hover:bg-emerald-500/10 text-xs font-bold text-slate-200 transition-all duration-150 text-center active:scale-95 cursor-pointer';
            }
        });
    }

    function calculateDepositLive(syncChips = true) {
        const input = document.getElementById('deposit_amount_input');
        if (!input) return;

        let amount = parseFloat(input.value) || 0;
        let fee = Math.round(amount * 0.02);
        let total = amount + fee;

        const liveAmount = document.getElementById('live_deposit_amount');
        const liveFee = document.getElementById('live_deposit_fee');
        const liveTotal = document.getElementById('live_deposit_total');

        if (liveAmount) liveAmount.textContent = 'Rp ' + amount.toLocaleString('id-ID');
        if (liveFee) liveFee.textContent = 'Rp ' + fee.toLocaleString('id-ID');
        if (liveTotal) liveTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');

        if (syncChips) {
            updateDepositChipState(amount);
        }
    }

    function handleTopUpSubmit(e, form) {
        const input = document.getElementById('deposit_amount_input');
        const amount = input ? parseFloat(input.value) : 0;

        if (isNaN(amount) || amount < 50000) {
            e.preventDefault();
            if (typeof showToast === 'function') {
                showToast('Nominal minimal top up adalah Rp 50.000', 'error');
            } else {
                alert('Nominal minimal top up adalah Rp 50.000');
            }
            if (input) input.focus();
            return false;
        }

        const btn = document.getElementById('btnSubmitTopUp');
        const icon = document.getElementById('btnSubmitTopUpIcon');
        const text = document.getElementById('btnSubmitTopUpText');

        if (btn) {
            btn.disabled = true;
            btn.classList.add('opacity-85', 'cursor-wait');
            if (icon) icon.className = 'fa-solid fa-circle-notch fa-spin text-xs';
            if (text) text.textContent = 'Menyiapkan QRIS...';
        }

        if (typeof window.showPageLoader === 'function') {
            window.showPageLoader('Menyiapkan Kode QRIS Scalify...');
        }

        return true;
    }

    function openWalletMutationsModal() {
        const modal = document.getElementById('walletMutationsModal');
        const content = document.getElementById('walletMutationsModalContent');
        if (!modal || !content) return;

        modal.classList.remove('opacity-0', 'pointer-events-none');
        setTimeout(() => {
            content.classList.remove('translate-y-full');
        }, 10);
    }

    function closeWalletMutationsModal() {
        const modal = document.getElementById('walletMutationsModal');
        const content = document.getElementById('walletMutationsModalContent');
        if (!modal || !content) return;

        content.classList.add('translate-y-full');
        setTimeout(() => {
            modal.classList.add('opacity-0', 'pointer-events-none');
        }, 300);
    }

    function openShareModal() {
        const modal = document.getElementById('shareModal');
        const content = document.getElementById('shareModalContent');

        modal.classList.remove('opacity-0', 'pointer-events-none');
        setTimeout(() => {
            content.classList.remove('translate-y-full');
        }, 10);
    }

    function closeShareModal() {
        const modal = document.getElementById('shareModal');
        const content = document.getElementById('shareModalContent');

        content.classList.add('translate-y-full');
        setTimeout(() => {
            modal.classList.add('opacity-0', 'pointer-events-none');
        }, 300);
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Coach Mark for Cara Kerja in Dashboard
        const hasSeenDashboardGuide = localStorage.getItem('hasSeenDashboardGuide');
        const coachMark = document.getElementById('dashboardCoachMark');

        if (!hasSeenDashboardGuide && coachMark) {
            // Show after a short delay
            setTimeout(() => {
                coachMark.classList.remove('hidden');
            }, 1000);
        }
    });

    function closeDashboardCoachMark() {
        const coachMark = document.getElementById('dashboardCoachMark');
        if (coachMark && !coachMark.classList.contains('hidden')) {
            coachMark.classList.add('hidden');
            localStorage.setItem('hasSeenDashboardGuide', 'true');
        }
    }

    // --- PUSH NOTIFICATION LOGIC ---
    const vapidPublicKey = "{{ config('webpush.vapid.public_key') }}";

    function urlB64ToUint8Array(base64String) {
        if (!base64String) return new Uint8Array(0);
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }

    async function subscribeUserToPush() {
        try {
            if (typeof Notification === 'undefined' || !Notification.requestPermission) {
                console.log('Browser tidak mendukung Push API (Atau Anda tidak menggunakan HTTPS)');
                return false;
            }

            const permission = await Notification.requestPermission();
            if (permission !== 'granted') return false;

            if (!navigator.serviceWorker || !navigator.serviceWorker.ready) {
                console.log('Service Worker tidak aktif.');
                return false;
            }

            const registration = await navigator.serviceWorker.ready;
            const subscribeOptions = {
                userVisibleOnly: true
                , applicationServerKey: urlB64ToUint8Array(vapidPublicKey)
            };

            const pushSubscription = await registration.pushManager.subscribe(subscribeOptions);
            await sendSubscriptionToBackEnd(pushSubscription);
            return true;
        } catch (error) {
            console.error('Error subscribing to push:', error);
            return false;
        }
    }

    async function sendSubscriptionToBackEnd(subscription) {
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : "{{ csrf_token() }}";
        const response = await fetch("{{ route('affiliate.push.subscribe') }}", {
            method: 'POST'
            , headers: {
                'Content-Type': 'application/json'
                , 'X-CSRF-TOKEN': csrfToken
            }
            , body: JSON.stringify(subscription)
        });

        if (!response.ok) {
            throw new Error('Bad status code from server.');
        }
        return response.json();
    }

    // Expose all functions to global window object for Livewire SPA compatibility
    window.showToast = showToast;
    window.copyLink = copyLink;
    window.copyLoginLink = copyLoginLink;
    window.openWithdrawModal = openWithdrawModal;
    window.closeWithdrawModal = closeWithdrawModal;
    window.openNotificationModal = openNotificationModal;
    window.closeNotificationModal = closeNotificationModal;
    window.openShareModal = openShareModal;
    window.closeShareModal = closeShareModal;
    window.closeDashboardCoachMark = closeDashboardCoachMark;
    window.subscribeUserToPush = subscribeUserToPush;

</script>
