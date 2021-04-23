<?php


namespace App\Service;

use \Stripe\StripeClient;

class PaymentService {
    private $stripe;

    public function __construct() {
        $this->stripe = new StripeClient('sk_test_51IgovzJufIouFh4tHbgJ17OG69qAxG5vFbPkVrJdPwAlesRNNiReIEy1C8han1dQV5hFq1RyOMFv41WN0XWdGKTp00PvA4P7XH');
    }

    public function create(): string {
        $items = [];
        $items[] = [
            'price' => 'price_1IguvaJufIouFh4tFfyAgd1b',
            'quantity' => 1,
        ];
        $protocol = $_SERVER['HTTPS'] ? 'https' : 'http';
        $host = $_SERVER['SERVER_NAME'];
        $successUrl = $protocol . '://' . $host . '/payment/success/{CHECKOUT_SESSION_ID}';
        $failureUrl = $protocol . '://' . $host . '/payment/failure/{CHECKOUT_SESSION_ID}';

        $session = $this->stripe->checkout->sessions->create([
            'success_url' => $successUrl,
            'cancel_url' => $failureUrl,
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'line_items' => $items
        ]);

        return $session->id;
    }

}

?>