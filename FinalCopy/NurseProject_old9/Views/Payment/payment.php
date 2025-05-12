<?php
$PATH = $_SERVER['SCRIPT_NAME'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeCare Service - Healing Hands, Familiar Spaces</title>
    <link rel="stylesheet" href="../../Views/styles/paymentstyle.css">
</head>
<body>
    <div class="payment-modal">
        <div class="header">
            <div class="logo">PaymentApp</div>
            <div class="close-button">✕</div>
        </div>
        
        <div class="title">Complete your payment</div>

        <!-- Payment Form Starts Here -->
        <form action="" method="POST" onsubmit="return validateForm();">
            <div class="form-group">
                <label for="card-name">Name on The Card</label>
                <input type="text" name="patientName"  required>
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
                <input type="text" name="serviceCode"  required>
            </div>
            
            <div class="form-group">
                 <label for="amount">Amount</label>
                <input type="text"  name="amount"  required>
            </div>
    </div>
    
    <button class="button">Pay Now</button>
    
    <div class="secure-badge">
      <div>🔒</div>
      <div>Secure Payment</div>
    </div>
  </div>
  <script>
    function validateForm() {
      const cardNumber = document.getElementById('card-number').value.replace(/\s+/g, '');
      const expiry = document.getElementById('expiry').value.trim();
      const cvv = document.getElementById('cvv').value.trim();
      const amount = parseFloat(document.getElementById('amount').value);

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

      if (expMonth < 1 || expMonth > 12) {
        alert("Expiry month must be between 01 and 12.");
        return false;
      }

      const now = new Date();
      const currentMonth = now.getMonth() + 1; 
      const currentYear = now.getFullYear();

      if (expYear < currentYear || (expYear === currentYear && expMonth < currentMonth)) {
        alert("Card has expired. Please use a valid card.");
        return false;
      }

      if (!/^\d{3}$/.test(cvv)) {
        alert("CVV must be exactly 3 digits.");
        return false;
      }


         if (isNaN(amount) || amount <= 0) {
                alert("Please enter a valid amount.");
                return false;
            }

      return true;
  
    }
    
  </script>
</body>
</html>
