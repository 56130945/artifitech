// Shepherd.js Product Tour
const productTour = {
    tour: null,

    init() {
        this.tour = new Shepherd.Tour({
            defaultStepOptions: {
                cancelIcon: {
                    enabled: true
                },
                classes: 'shepherd-theme-custom',
                scrollTo: true
            }
        });

        this.addSteps();
        this.addEventListeners();
    },

    addSteps() {
        this.tour.addStep({
            id: 'welcome',
            text: 'Welcome to ArtifiTech! Let us show you around.',
            attachTo: {
                element: '.hero-section',
                on: 'bottom'
            },
            buttons: [
                {
                    text: 'Skip',
                    action: this.tour.complete
                },
                {
                    text: 'Next',
                    action: this.tour.next
                }
            ]
        });

        // Add more steps as needed for your specific features
    },

    addEventListeners() {
        document.querySelector('#start-tour').addEventListener('click', () => {
            this.tour.start();
        });
    }
};

document.addEventListener('DOMContentLoaded', () => productTour.init());

// Modal functionality
document.addEventListener('DOMContentLoaded', function() {
    const loginBtn = document.getElementById('loginBtn');
    const registerBtn = document.getElementById('registerBtn');
    const loginModal = document.getElementById('loginModal');
    const registerModal = document.getElementById('registerModal');
    const closeBtns = document.getElementsByClassName('close');

    // Open login modal
    loginBtn.onclick = function() {
        loginModal.style.display = "block";
    }

    // Open register modal
    registerBtn.onclick = function() {
        registerModal.style.display = "block";
    }

    // Close modals when clicking (x)
    Array.from(closeBtns).forEach(btn => {
        btn.onclick = function() {
            loginModal.style.display = "none";
            registerModal.style.display = "none";
        }
    });

    // Close modals when clicking outside
    window.onclick = function(event) {
        if (event.target == loginModal) {
            loginModal.style.display = "none";
        }
        if (event.target == registerModal) {
            registerModal.style.display = "none";
        }
    }

    // Handle form submissions
    document.getElementById('loginForm').onsubmit = function(e) {
        e.preventDefault();
        // Add your login logic here
        console.log('Login form submitted');
    }

    document.getElementById('registerForm').onsubmit = function(e) {
        e.preventDefault();
        // Add your registration logic here
        console.log('Register form submitted');
    }
}); 