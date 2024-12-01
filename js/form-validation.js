// Form Validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.contact-form');
    if (!form) return;

    const fields = {
        name: {
            regex: /^[a-zA-Z\s]{2,50}$/,
            error: 'Please enter a valid name (2-50 characters, letters only)'
        },
        email: {
            regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            error: 'Please enter a valid email address'
        },
        subject: {
            regex: /^.{5,100}$/,
            error: 'Subject must be between 5 and 100 characters'
        },
        message: {
            regex: /^[\s\S]{10,1000}$/,
            error: 'Message must be between 10 and 1000 characters'
        }
    };

    // Create feedback elements
    Object.keys(fields).forEach(fieldName => {
        const input = form.querySelector(`[name="${fieldName}"]`);
        if (input) {
            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            feedback.textContent = fields[fieldName].error;
            input.parentNode.appendChild(feedback);

            // Real-time validation
            input.addEventListener('input', () => validateField(input, fields[fieldName]));
            input.addEventListener('blur', () => validateField(input, fields[fieldName]));
        }
    });

    // Validate single field
    function validateField(input, rules) {
        const value = input.value.trim();
        const isValid = rules.regex.test(value);
        
        input.classList.toggle('is-invalid', !isValid);
        input.classList.toggle('is-valid', isValid);
        
        return isValid;
    }

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let isValid = true;

        // Validate all fields
        Object.keys(fields).forEach(fieldName => {
            const input = form.querySelector(`[name="${fieldName}"]`);
            if (input && !validateField(input, fields[fieldName])) {
                isValid = false;
            }
        });

        if (isValid) {
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...';

            // Simulate form submission (replace with actual API call)
            setTimeout(() => {
                // Success message
                const alert = document.createElement('div');
                alert.className = 'alert alert-success mt-3 animate__animated animate__fadeIn';
                alert.role = 'alert';
                alert.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>Thank you! Your message has been sent successfully.';
                form.appendChild(alert);

                // Reset form
                form.reset();
                form.querySelectorAll('.is-valid').forEach(el => el.classList.remove('is-valid'));
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;

                // Remove success message after 5 seconds
                setTimeout(() => {
                    alert.classList.replace('animate__fadeIn', 'animate__fadeOut');
                    setTimeout(() => alert.remove(), 1000);
                }, 5000);
            }, 1500);
        }
    });
}); 