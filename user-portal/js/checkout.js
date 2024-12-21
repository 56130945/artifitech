document.addEventListener('DOMContentLoaded', function() {
    // Initialize Stripe
    const stripe = Stripe('your_publishable_key');
    const elements = stripe.elements();

    // Create card element
    const card = elements.create('card');
    card.mount('#card-element');

    // Handle form submission
    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');

    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        submitButton.disabled = true;

        try {
            const { paymentMethod, error } = await stripe.createPaymentMethod({
                type: 'card',
                card: card,
                billing_details: {
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value
                }
            });

            if (error) {
                throw error;
            }

            // Send payment info to server
            const response = await fetch('/process-payment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    payment_method_id: paymentMethod.id,
                    product_id: document.getElementById('product-id').value,
                    email: document.getElementById('email').value
                })
            });

            const result = await response.json();

            if (result.error) {
                throw new Error(result.error);
            }

            // Handle successful payment
            window.location.href = '/payment-success.php?order_id=' + result.order_id;

        } catch (error) {
            const errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
            submitButton.disabled = false;
        }
    });
}); 