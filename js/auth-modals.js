document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to buttons
    document.querySelectorAll('.btn-login').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('loginModal').style.display = 'block';
        });
    });

    document.querySelectorAll('.btn-register').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('registerModal').style.display = 'block';
        });
    });

    // Close modal when clicking close button
    document.querySelectorAll('.close').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.modal').style.display = 'none';
        });
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    });
}); 