document.addEventListener('DOMContentLoaded', () => {
    console.log('Black Friday Modal Script Loaded');
    const modalOverlay = document.getElementById('modalOverlay');
    const closeButton = document.getElementById('closeButton');
    const modal = modalOverlay.querySelector('.black-friday-modal');

    function showModal() {
        console.log('Showing modal...');
        modalOverlay.style.display = 'flex';
        modalOverlay.offsetHeight;
        requestAnimationFrame(() => {
            modalOverlay.classList.add('active');
            modal.style.opacity = '1';
            modal.style.transform = 'scale(1)';
        });
    }

    function hideModal() {
        console.log('Hiding modal...');
        modalOverlay.classList.remove('active');
        modal.style.opacity = '0';
        modal.style.transform = 'scale(0.7)';
        setTimeout(() => {
            modalOverlay.style.display = 'none';
        }, 300);
    }

    // Show modal after 2 seconds if not shown before
    if (!sessionStorage.getItem('modalShown')) {
        console.log('Modal not shown before, showing in 2 seconds...');
        setTimeout(showModal, 2000);
        sessionStorage.setItem('modalShown', 'true');
    } else {
        console.log('Modal already shown this session');
    }

    // Close modal when clicking the close button
    closeButton.addEventListener('click', (e) => {
        console.log('Close button clicked');
        e.preventDefault();
        hideModal();
    });

    // Close modal when clicking outside
    modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay) {
            console.log('Clicked outside modal');
            hideModal();
        }
    });

    // Prevent modal content clicks from bubbling to overlay
    modal.addEventListener('click', (e) => {
        e.stopPropagation();
    });

    // Handle Shop Now button click
    const shopNowButton = modal.querySelector('.black-friday-cta');
    if (shopNowButton) {
        shopNowButton.addEventListener('click', () => {
            console.log('Shop Now clicked');
            hideModal();
        });
    }
});
