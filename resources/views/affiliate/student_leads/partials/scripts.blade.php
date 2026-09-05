<script>
    let currentAiLead = {
        id: null
        , name: ''
        , waNumber: ''
        , needs: ''
        , claimUrl: null
    };

    document.addEventListener('DOMContentLoaded', () => {
        const hasSeenCoachMark = localStorage.getItem('hasSeenStudentLeadCoachMark');
        if (!hasSeenCoachMark) {
            const coachMark = document.getElementById('coach-mark');
            if (coachMark) {
                coachMark.classList.remove('hidden');
                setTimeout(() => {
                    coachMark.classList.remove('scale-0', 'opacity-0');
                    coachMark.classList.add('scale-100', 'opacity-100');
                }, 100);
            }
        }
    });

    function dismissCoachMark() {
        const coachMark = document.getElementById('coach-mark');
        if (coachMark && !coachMark.classList.contains('hidden')) {
            coachMark.classList.remove('scale-100', 'opacity-100');
            coachMark.classList.add('scale-0', 'opacity-0');
            setTimeout(() => {
                coachMark.classList.add('hidden');
            }, 500);
            localStorage.setItem('hasSeenStudentLeadCoachMark', 'true');
        }
    }

    function openAddLeadModal() {
        const modal = document.getElementById('addLeadModal');
        const content = document.getElementById('addLeadModalContent');

        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('translate-y-full');
        }, 10);
    }

    function closeAddLeadModal() {
        const content = document.getElementById('addLeadModalContent');
        content.classList.add('translate-y-full');

        setTimeout(() => {
            document.getElementById('addLeadModal').classList.add('hidden');
        }, 300);
    }

    function openEditLeadModal(id, name, waNumber, needs) {
        const modal = document.getElementById('editLeadModal');
        const content = document.getElementById('editLeadModalContent');
        const form = document.getElementById('editLeadForm');

        document.getElementById('editName').value = name === 'Anonim' ? '' : name;
        document.getElementById('editWaNumber').value = waNumber;
        document.getElementById('editNeeds').value = needs === 'Belum Diketahui' ? '' : needs;

        form.action = `/partner/student-leads/${id}`;

        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('translate-y-full');
        }, 10);
    }

    function closeEditLeadModal() {
        const content = document.getElementById('editLeadModalContent');
        content.classList.add('translate-y-full');

        setTimeout(() => {
            document.getElementById('editLeadModal').classList.add('hidden');
        }, 300);
    }

    // AI Offer Modal Functions
    function openAiOfferModal(leadId, leadName, waNumber, leadNeeds, claimUrl = null) {
        currentAiLead = {
            id: leadId
            , name: leadName
            , waNumber: waNumber
            , needs: leadNeeds
            , claimUrl: claimUrl
        };

        document.getElementById('aiTargetName').textContent = leadName || 'Anonim';
        document.getElementById('aiTargetNeeds').textContent = leadNeeds || 'Skripsi / Tugas Akhir';
        document.getElementById('aiMessageResult').value = '';
        document.getElementById('aiProductSelect').value = '';

        const modal = document.getElementById('aiOfferModal');
        const content = document.getElementById('aiOfferModalContent');

        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('translate-y-full');
        }, 10);

        // Auto trigger first generation
        executeAiGeneration();
    }

    function closeAiOfferModal() {
        const content = document.getElementById('aiOfferModalContent');
        content.classList.add('translate-y-full');

        setTimeout(() => {
            document.getElementById('aiOfferModal').classList.add('hidden');
        }, 300);
    }

    async function executeAiGeneration() {
        if (!currentAiLead.id) return;

        const btn = document.getElementById('btnGenerateAi');
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1.5"></i> Merangkai Pesan...';
        btn.disabled = true;

        const aiModal = document.getElementById('aiLoadingModal');
        if (aiModal) {
            aiModal.classList.remove('hidden');
        }

        const selectedProductId = document.getElementById('aiProductSelect').value;
        const generateUrl = `/partner/student-leads/${currentAiLead.id}/generate-ai-chat`;

        try {
            const response = await fetch(generateUrl, {
                method: 'POST'
                , headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    , 'Accept': 'application/json'
                    , 'Content-Type': 'application/json'
                }
                , body: JSON.stringify({
                    digital_product_id: selectedProductId || null
                })
            });

            const data = await response.json();

            if (data.success && data.text) {
                document.getElementById('aiMessageResult').value = data.text;
            } else {
                alert('Gagal: ' + (data.message || 'Terjadi kesalahan'));
            }
        } catch (e) {
            console.error(e);
            alert('Gagal menghubungi AI.');
        } finally {
            btn.innerHTML = originalHtml;
            btn.disabled = false;
            if (aiModal) {
                aiModal.classList.add('hidden');
            }
        }
    }

    async function sendAiMessageToWa() {
        const text = document.getElementById('aiMessageResult').value.trim();
        if (!text) {
            alert('Pesan masih kosong. Silakan generate pesan terlebih dahulu.');
            return;
        }

        if (currentAiLead.claimUrl) {
            try {
                await fetch(currentAiLead.claimUrl, {
                    method: 'POST'
                    , headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        , 'Accept': 'application/json'
                        , 'Content-Type': 'application/json'
                    }
                });
            } catch (e) {
                console.error('Failed to claim lead', e);
            }
        }

        let formattedNumber = currentAiLead.waNumber ? currentAiLead.waNumber.toString().replace(/[^0-9]/g, '') : '';
        if (formattedNumber.startsWith('0')) {
            formattedNumber = '62' + formattedNumber.substring(1);
        }

        let waUrl = '';
        if (formattedNumber) {
            waUrl = `https://api.whatsapp.com/send?phone=${formattedNumber}&text=${encodeURIComponent(text)}`;
        } else {
            waUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(text)}`;
        }

        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            let a = document.createElement('a');
            a.href = waUrl;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        } else {
            let a = document.createElement('a');
            a.target = '_blank';
            a.href = waUrl;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }

        closeAiOfferModal();

        if (currentAiLead.claimUrl) {
            setTimeout(() => {
                window.location.href = "{{ route('affiliate.student_leads.index', ['tab' => 'my_leads']) }}";
            }, 1500);
        }
    }

    async function kirimWaLangsungAffiliate(selectElement, leadId, leadName, waNumber, linkLandingPage, linkProposal, claimUrl = null) {
        if (!selectElement.value) return;

        let text = decodeURIComponent(escape(window.atob(selectElement.value)));

        if (leadName && leadName !== 'Anonim') {
            text = text.replace(/\{nama_bisnis\}/g, leadName);
            text = text.replace(/\{nama\}/g, leadName);
        }
        if (linkLandingPage) {
            text = text.replace(/\{link_landing_page\}/g, linkLandingPage);
            text = text.replace(/\{link_landing\}/g, linkLandingPage);
        }
        if (linkProposal) {
            text = text.replace(/\{link_proposal\}/g, linkProposal);
        }

        let formattedNumber = waNumber ? waNumber.toString().replace(/[^0-9]/g, '') : '';
        if (formattedNumber.startsWith('0')) {
            formattedNumber = '62' + formattedNumber.substring(1);
        }

        let waUrl = '';
        if (formattedNumber) {
            waUrl = `https://api.whatsapp.com/send?phone=${formattedNumber}&text=${encodeURIComponent(text)}`;
        } else {
            waUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(text)}`;
        }

        if (claimUrl) {
            try {
                await fetch(claimUrl, {
                    method: 'POST'
                    , headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        , 'Accept': 'application/json'
                        , 'Content-Type': 'application/json'
                    }
                });
            } catch (e) {
                console.error('Failed to claim lead', e);
            }
        }

        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            window.location.href = waUrl;
        } else {
            window.open(waUrl, '_blank');
        }

        selectElement.value = "";

        if (claimUrl) {
            setTimeout(() => {
                window.location.href = "{{ route('affiliate.student_leads.index', ['tab' => 'my_leads']) }}";
            }, 500);
        }
    }

</script>
