document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const loginMessage = document.getElementById('loginMessage');
    const registerMessage = document.getElementById('registerMessage');

    // Helper function to show messages
    const showMessage = (element, message, type) => {
        element.style.display = 'block';
        const alert = element.querySelector('.alert');
        alert.textContent = message;
        alert.className = `alert alert-${type}`;
    };

    // Login form handler
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            try {
                const formData = new FormData(loginForm);
                const response = await fetch('/api/auth/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    // Store the token
                    localStorage.setItem('token', data.token);
                    showMessage(loginMessage, 'Login successful! Redirecting...', 'success');
                    
                    // Redirect to dashboard after 1 second
                    setTimeout(() => {
                        window.location.href = '/dashboard.php';
                    }, 1000);
                } else {
                    showMessage(loginMessage, data.message || 'Login failed. Please check your credentials.', 'danger');
                }
            } catch (error) {
                showMessage(loginMessage, 'An error occurred. Please try again.', 'danger');
                console.error('Login error:', error);
            }
        });
    }

    // Registration form handler
    if (registerForm) {
        // Password validation
        const validatePassword = () => {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (password !== confirmPassword) {
                showMessage(registerMessage, 'Passwords do not match!', 'danger');
                return false;
            }
            
            if (password.length < 6) {
                showMessage(registerMessage, 'Password must be at least 6 characters long!', 'danger');
                return false;
            }
            
            return true;
        };

        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            if (!validatePassword()) {
                return;
            }

            try {
                const formData = new FormData(registerForm);
                const response = await fetch('/api/auth/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    showMessage(registerMessage, 'Registration successful! Redirecting to login...', 'success');
                    
                    // Clear form
                    registerForm.reset();
                    
                    // Redirect to login page after 2 seconds
                    setTimeout(() => {
                        window.location.href = '/login.php';
                    }, 2000);
                } else {
                    showMessage(registerMessage, data.message || 'Registration failed. Please try again.', 'danger');
                }
            } catch (error) {
                showMessage(registerMessage, 'An error occurred. Please try again.', 'danger');
                console.error('Registration error:', error);
            }
        });

        // Real-time password validation
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirmPassword');
        
        [passwordInput, confirmPasswordInput].forEach(input => {
            input.addEventListener('input', () => {
                if (passwordInput.value && confirmPasswordInput.value) {
                    validatePassword();
                }
            });
        });
    }
}); 