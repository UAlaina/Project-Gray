<?php
$PATH = $_SERVER['SCRIPT_NAME'];
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HomeCare Service - Healing Hands, Familiar Spaces</title>
        <link rel="stylesheet" href="Views/styles/paymentstyle.css">
      </head>
<body>
  <div class="payment-modal">
    <div class="header">
      <div class="logo">PaymentApp</div>
      <div class="close-button">✕</div>
    </div>
    
    <div class="title">Complete your payment</div>

    <div class="form-group">
        <label for="card-Name">Name on The Card</label>
        <input type="text" id="card-number" class="input-field">
      </div>
    
    <div class="form-group">
      <label for="card-number">Card Number</label>
      <input type="text" id="card-number" class="input-field" placeholder="1234 5678 9012 3456">
    </div>
    
    <div style="display: flex; gap: 16px;">
      <div class="form-group" style="flex: 1;">
        <label for="expiry">Expiry Date</label>
        <input type="text" id="expiry" class="input-field" placeholder="MM/YY">
      </div>
      <div class="form-group" style="flex: 1;">
        <label for="cvv">CVV</label>
        <input type="text" id="cvv" class="input-field" placeholder="123">
      </div>
    </div>
    
    <div class="form-group">
      <label for="service-code">Service Code</label>
      <input type="text" id="service-code" class="input-field service-code">
    </div>
    
    <!-- Example -->
    <div class="amount-row">
      <div class="amount-label">Total Amount</div>
      <div class="amount-value">$0.00</div>
    </div>
    
    <button class="button">Pay Now</button>
    
    <div class="secure-badge">
      <div>🔒</div>
      <div>Secure Payment</div>
    </div>
  </div>
</body>
</html>