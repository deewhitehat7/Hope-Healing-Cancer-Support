<?php
require_once '../includes/config.php';

$transactionId = filter_input(INPUT_GET, 'transaction_id', FILTER_SANITIZE_STRING);

// Get donation details
$stmt = $pdo->prepare("SELECT * FROM donations WHERE transaction_id = ?");
$stmt->execute([$transactionId]);
$donation = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donation Successful | <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <main class="container text-center">
        <div class="success-icon">?</div>
        <h1>Thank You for Your Generosity!</h1>
        
        <div class="receipt-box">
            <p>We've received your donation of <strong>$<?php echo number_format($donation['amount'], 2); ?></strong></p>
            <p>Transaction ID: <?php echo $donation['transaction_id']; ?></p>
            
            <div class="impact-statement">
                <h3>Your Impact</h3>
                <p>This donation will help provide:</p>
                <ul>
                    <li>? <?php echo floor($donation['amount'] / 50); ?> days of chemotherapy drugs</li>
                    <li>? <?php echo floor($donation['amount'] / 25); ?> cancer screening tests</li>
                </ul>
            </div>
            
            <a href="../index.php" class="btn btn-primary">Return Home</a>
            <a href="#" class="btn btn-secondary">Download Receipt</a>
        </div>
    </main>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>