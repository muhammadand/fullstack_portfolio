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

</script>
