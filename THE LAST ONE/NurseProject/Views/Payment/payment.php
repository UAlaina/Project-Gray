<?php
$PATH = $_SERVER['SCRIPT_NAME'];
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$patientName = $_SESSION['user_email'] ?? 'Unknown';
$basePath = '/NurseProject';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HomeCare Service - Healing Hands, Familiar Spaces</title>
  <link rel="stylesheet" href="/NurseProject/Views/styles/paymentstyle.css">
</head>
<body>
  <div class="payment-modal">
    <div class="header">
      <div class="logo">PaymentApp</div>
      <a href="/NurseProject/index.php?controller=patient&action=mainpage" class="close-button">✕</a>
    </div>

    <div class="title">Complete your payment</div>

    <form action="/NurseProject/index.php?controller=payment&action=submit" method="POST" onsubmit="return validateForm();">
      <div class="form-group">
        <label for="card-name">Name on The Card</label>
        <input type="text" id="card-name" name="card_name" class="input-field" required>
      </div>

      <div class="form-group">
        <label for="card-number">Card Number</label>
        <input type="text" id="card-number" name="card_number" class="input-field" placeholder="1234 5678 9012 3456" required>
      </div>

      <div style="display: flex; gap: 16px;">
        <div class="form-group" style="flex: 1;">
          <label for="expiry">Expiry Date</label>
          <input type="text" id="expiry" name="expiry_date" class="input-field" placeholder="MM/YY" required>
        </div>
        <div class="form-group" style="flex: 1;">
          <label for="cvv">CVV</label>
          <input type="text" id="cvv" name="cvv" class="input-field" placeholder="123" required>
        </div>
      </div>

      <div class="form-group">
        <label for="service-code">Service Code</label>
        <input type="text" id="service-code" name="service_code" class="input-field service-code" required>
      </div>

      <div class="form-group">
        <label for="amount">Amount ($)</label>
        <input type="number" id="amount" name="amount" class="input-field" step="0.01" min="0" required>
      </div>

      <input type="hidden" name="patient_name" value="<?php echo htmlspecialchars($patientName); ?>">

      <div class="amount-row">
        <div class="amount-label">Total Amount</div>
        <div class="amount-value" id="amountDisplay">$0.00</div>
      </div>

      <button class="button" type="submit">Pay Now</button>

      <div class="secure-badge">
        <div>🔒</div>
        <div>Secure Payment</div>
      </div>
    </form>
  </div>

  <script>
    document.getElementById("amount").addEventListener("input", function () {
      const val = parseFloat(this.value || 0).toFixed(2);
      document.getElementById("amountDisplay").innerText = "$" + val;
    });

    function validateForm() {
      const cardNumber = document.getElementById('card-number').value.replace(/\s+/g, '');
      const expiry = document.getElementById('expiry').value.trim();
      const cvv = document.getElementById('cvv').value.trim();

      if (!/^\d{16}$/.test(cardNumber)) {
        alert("Please enter a valid 16-digit card number.");
        return false;
      }

      const match = expiry.match(/^(\d{2})\/(\d{2})$/);
      if (!match) {
        alert("Please enter a valid expiry date in MM/YY format.");
        return false;
      }

      const expMonth = parseInt(match[1], 10);
      const expYear = parseInt("20" + match[2], 10);

      const now = new Date();
      const currentMonth = now.getMonth() + 1;
      const currentYear = now.getFullYear();

      if (expMonth < 1 || expMonth > 12 || expYear < currentYear || (expYear === currentYear && expMonth < currentMonth)) {
        alert("Card has expired. Please use a valid card.");
        return false;
      }

      if (!/^\d{3}$/.test(cvv)) {
        alert("CVV must be exactly 3 digits.");
        return false;
      }

      return true;
    }
  </script>
</body>
</html>
