const registrationForm = document.getElementById('registrationForm');
const messageDiv = document.getElementById('message');

registrationForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    try {
        const formData = new FormData(registrationForm);
        const response = await fetch('/api/auth/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(Object.fromEntries(formData))
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Show success message
            messageDiv.className = 'alert alert-success';
            messageDiv.textContent = data.message;
            
            // Optional: Clear the form
            registrationForm.reset();
            
            // Optional: Redirect to login page after 2 seconds
            setTimeout(() => {
                window.location.href = '/login';
            }, 2000);
        } else {
            // Show error message
            messageDiv.className = 'alert alert-danger';
            messageDiv.textContent = data.message;
        }
    } catch (error) {
        messageDiv.className = 'alert alert-danger';
        messageDiv.textContent = 'An error occurred. Please try again.';
    }
}); 