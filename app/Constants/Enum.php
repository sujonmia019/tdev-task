<?php

namespace App\Constants;

class Enum {

    const ACTIVE = 1; // Active
    const EXPIRED = 2; // Expired
    const CANCELLED = 3; // Cancelled

    // Payment Status
    const PENDING = 1;
    const COMPLETE = 2;
    const FAILED = 3;

    // Payment Gateway
    const PAYPAL = 'paypal';
    const STRIPE = 'stripe';

    const PAYMENT_STATUS_LABEL = [
        1 => 'Pending',
        2 => 'Complete',
        3 => 'Failed'
    ];

}
