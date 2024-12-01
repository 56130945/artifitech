// Live Demo Implementation
const liveDemo = {
    init() {
        this.setupDemoControls();
        this.setupDemoPreview();
    },

    setupDemoControls() {
        const demoControls = document.querySelectorAll('.demo-control');
        demoControls.forEach(control => {
            control.addEventListener('change', (e) => {
                this.updatePreview(e.target.name, e.target.value);
            });
        });
    },

    setupDemoPreview() {
        // Initialize demo preview with default values
        this.demoFrame = document.querySelector('#demo-preview');
        this.updatePreview();
    },

    updatePreview(property, value) {
        // Update the live preview based on user interactions
        if (this.demoFrame && property && value) {
            this.demoFrame.contentWindow.postMessage({
                type: 'demo-update',
                property,
                value
            }, '*');
        }
    }
};

document.addEventListener('DOMContentLoaded', () => liveDemo.init()); 