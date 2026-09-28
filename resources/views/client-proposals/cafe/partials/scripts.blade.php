<script>
    // Menu Category Filtering Logic
    function filterMenu(categoryId, btnEl) {
        // Toggle Active Styles on buttons
        const allBtns = document.querySelectorAll('.menu-filter-btn');
        allBtns.forEach(btn => {
            btn.classList.remove('bg-[#C59B6C]', 'text-[#140F0C]', 'font-bold', 'shadow-md');
            btn.classList.add('bg-white/5', 'text-white/70', 'hover:bg-white/10');
        });

        if (btnEl) {
            btnEl.classList.add('bg-[#C59B6C]', 'text-[#140F0C]', 'font-bold', 'shadow-md');
            btnEl.classList.remove('bg-white/5', 'text-white/70');
        }

        const cards = document.querySelectorAll('.menu-item-card');
        cards.forEach(card => {
            const cardCat = card.getAttribute('data-cat');
            if (categoryId === 'all' || cardCat === categoryId) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function filterCategoryOnLanding(categoryId) {
        const targetBtn = document.querySelector(`.menu-filter-btn[data-category="${categoryId}"]`);
        if (targetBtn) {
            filterMenu(categoryId, targetBtn);
        }
    }

    // Quick Order Modal
    function openQuickOrderModal(productId) {
        const menuList = (typeof CAFE_DATABASE !== 'undefined' && CAFE_DATABASE.menu) ? CAFE_DATABASE.menu : [];
        const item = menuList.find(m => m.id === productId);
        if (!item) return;

        document.getElementById('modalProductName').innerText = item.name;
        document.getElementById('modalProductDesc').innerText = item.description;
        document.getElementById('modalProductBadge').innerText = item.badge;
        document.getElementById('modalProductPrice').innerText = 'Rp ' + Number(item.price).toLocaleString('id-ID');
        document.getElementById('modalProductImage').src = item.image;

        const modal = document.getElementById('quickOrderModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeQuickOrderModal() {
        const modal = document.getElementById('quickOrderModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Close on outside click
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('quickOrderModal');
        if (e.target === modal) {
            closeQuickOrderModal();
        }
    });
</script>
