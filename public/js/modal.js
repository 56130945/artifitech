class PromotionalModal {
    constructor() {
        this.modal = document.getElementById('christmasModal');
        this.closeButton = document.getElementById('closeButton');
        this.init();
    }

    init() {
        setTimeout(() => this.show(), 3000);
        this.setupEventListeners();
    }

    show() {
        if (this.modal) {
            this.modal.style.display = 'block';
            this.createSnowflakes();
        }
    }

    hide() {
        if (this.modal) {
            this.modal.style.display = 'none';
        }
    }

    createSnowflakes() {
        const numberOfSnowflakes = 50;
        const overlay = document.getElementById('modalOverlay');
        
        for (let i = 0; i < numberOfSnowflakes; i++) {
            const snowflake = document.createElement('div');
            snowflake.className = 'snowflake';
            snowflake.innerHTML = '❄';
            snowflake.style.left = Math.random() * 100 + 'vw';
            snowflake.style.animationDuration = Math.random() * 3 + 2 + 's';
            snowflake.style.opacity = Math.random();
            snowflake.style.fontSize = Math.random() * 20 + 10 + 'px';
            overlay.appendChild(snowflake);
        }
    }

    setupEventListeners() {
        if (this.closeButton) {
            this.closeButton.addEventListener('click', () => this.hide());
        }

        if (this.modal) {
            this.modal.addEventListener('click', (e) => {
                if (e.target === this.modal) {
                    this.hide();
                }
            });
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new PromotionalModal();
});
