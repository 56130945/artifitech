<?php
if (!defined('STRIPE_CONFIG_LOADED')) {
    define('STRIPE_CONFIG_LOADED', true);
    
    $stripe = [
        'secret_key'      => 'test_key',
        'publishable_key' => 'test_key'
    ];
    
    class MockStripe {
        public static function createPaymentIntent($amount, $currency = 'usd') {
            // Simulate a successful payment intent
            return [
                'id' => 'pi_' . uniqid(),
                'client_secret' => 'test_secret_' . uniqid(),
                'amount' => $amount,
                'currency' => $currency,
                'status' => 'requires_payment_method'
            ];
        }
        
        public static function confirmPayment($paymentIntentId) {
            // Simulate payment confirmation
            return [
                'id' => $paymentIntentId,
                'status' => 'succeeded',
                'amount' => 1000,
                'currency' => 'usd'
            ];
        }
    }
    
    // Create alias for compatibility
    class Stripe {
        public static function setApiKey($key) {
            // Mock implementation
            return true;
        }
    }
    
    // Initialize mock payment system
    Stripe::setApiKey($stripe['secret_key']);
}