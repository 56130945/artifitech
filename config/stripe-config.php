<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Replace with your Stripe API keys
$stripe = [
    'publishable_key' => 'pk_test_your_publishable_key',
    'secret_key' => 'sk_test_your_secret_key'
];

\Stripe\Stripe::setApiKey($stripe['secret_key']);