<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

// Validate input
$required = ['name', 'email', 'amount', 'card_number', 'expiry', 'cvv'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        http_response_code(400);
        die(json_encode(['error' => "Missing required field: $field"]));
    }
}

// Sanitize inputs
$data = [
    'name' => filter_var($_POST['name'], FILTER_SANITIZE_STRING),
    'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
    'amount' => (float) ($_POST['amount'] === 'custom' ? $_POST['custom_amount'] : $_POST['amount']),
    'card_number' => preg_replace('/\D/', '', $_POST['card_number']),
    'recurring' => isset($_POST['recurring'])
];

// Validate card (Luhn algorithm)
if (!validateCard($data['card_number'])) {
    http_response_code(422);
    die(json_encode(['error' => 'Invalid card number']));
}

// Process payment (using Stripe/PayPal SDK in production)
try {
    // In production, replace with actual payment processor API call
    $transactionId = 'TEST_' . bin2hex(random_bytes(8));

    // Record donation in database
    $stmt = $pdo->prepare("INSERT INTO donations 
        (transaction_id, donor_name, donor_email, amount, recurring, status)
        VALUES (?, ?, ?, ?, ?, 'completed')");
    $stmt->execute([
        $transactionId,
        $data['name'],
        $data['email'],
        $data['amount'],
        $data['recurring'] ? 1 : 0
    ]);

    // Send confirmation email
    sendDonationEmail($data['email'], $data['name'], $data['amount'], $transactionId);

    // Redirect to success page
    header("Location: success.php?transaction_id=$transactionId");
    exit;

} catch (Exception $e) {
    http_response_code(500);
    die(json_encode(['error' => 'Payment processing failed']));
}

function validateCard($number)
{
    $sum = 0;
    $alt = false;
    for ($i = strlen($number) - 1; $i >= 0; $i--) {
        $n = $number[$i];
        if ($alt) {
            $n *= 2;
            if ($n > 9)
                $n = ($n % 10) + 1;
        }
        $sum += $n;
        $alt = !$alt;
    }
    return ($sum % 10) == 0;
}
?>