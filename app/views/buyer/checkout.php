<!DOCTYPE html>
<html>
<head>
    <title>Checkout - GameStore</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav>
        <h1>Checkout</h1>
        <a href="index.php?action=home">Cancel</a>
    </nav>

    <div class="container">
        <form action="index.php?action=confirm_purchase" method="POST">
            <input type="hidden" name="game_id" value="<?php echo $game['id']; ?>">
            <input type="hidden" name="amount" value="<?php echo $game['price']; ?>">

            <div style="background: white; padding: 20px; border-radius: 8px;">
                <h2>Order Summary</h2>
                <p><strong>Game:</strong> <?php echo $game['title']; ?></p>
                <p><strong>Price:</strong> $<?php echo $game['price']; ?></p>
                <hr>
                
                <h3>Select Payment Method:</h3>
                <label style="display:block; margin: 10px 0;">
                    <input type="radio" name="payment_method" value="bkash" required> 
                    Bkash (Mobile Banking)
                </label>
                <label style="display:block; margin: 10px 0;">
                    <input type="radio" name="payment_method" value="nagad" required> 
                    Nagad (Mobile Banking)
                </label>
                <label style="display:block; margin: 10px 0;">
                    <input type="radio" name="payment_method" value="card" required> 
                    Credit Card (Visa/Mastercard)
                </label>
                
                <br>
                <label>Account/Card Number:</label>
                <input type="text" placeholder="XXXX-XXXX-XXXX" required>
                
                <label>PIN / CVV:</label>
                <input type="password" placeholder="***" required>

                <br><br>
                <button type="submit" style="background: #27ae60; width: 100%;">Confirm Payment</button>
            </div>
        </form>
    </div>
</body>
</html>