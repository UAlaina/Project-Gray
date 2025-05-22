<?php
$PATH = $_SERVER['SCRIPT_NAME'];
$payments = $payments ?? []; 
?>

<pre>
<?php print_r($payments); ?>
</pre>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment History</title>
  <link rel="stylesheet" href="/NurseProject/Views/styles/paymentstyle.css">
</head>
<body>
  <div class="payment-modal">
    <div class="header">
      <div class="logo">Payment History</div>
      <a href="/NurseProject/index.php?controller=patient&action=mainpage"><div class="close-button">✕</div></a>
    </div>

    <div class="title">Your Payment History</div>

    <table class="payment-table">
      <tr>
        <th>Date</th>
        <th>Service Code</th>
        <th>Amount ($)</th>
        <th>Status</th>
      </tr>
      <?php if (!empty($payments)) : ?>
        <?php foreach ($payments as $payment) : ?>
    <tr>
        <td><?= htmlspecialchars($payment->timeStamp) ?></td>
        <td><?= htmlspecialchars($payment->serviceCode) ?></td>
        <td><?= htmlspecialchars($payment->amount) ?></td>
        <td><?= htmlspecialchars($payment->paymentStatus) ?></td>
    </tr>
<?php endforeach; ?>

      <?php else : ?>
        <tr>
          <td colspan="4">No payment records found.</td>
        </tr>
      <?php endif; ?>
    </table>
  </div>
</body>
</html>