<!DOCTYPE html>
<html>
<head>
    <title>Checkout - GameStore</title>
    <link rel="stylesheet" href="assets/css/checkout.css">
</head>
<body>
    <nav>
        <h1>Checkout</h1>
        <a href="index.php?action=home">Cancel</a>
    </nav>

    <div class="container">
        
        <div style="background: #38384ada; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <h2>Order Summary</h2>
            <div style="display: flex; gap: 20px; align-items: center;">
                <img src="uploads/images/<?php echo $game['image_path']; ?>" style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">
                <div>
                    <h3><?php echo $game['title']; ?></h3>
                    <p><?php echo substr($game['description'], 0, 100) . '...'; ?></p>
                </div>
            </div>
            <hr>

            <?php if(isset($discount) && $discount > 0): ?>
                <p>Original Price: <span style="text-decoration: line-through; color: #999;">$<?php echo number_format($game['price'], 2); ?></span></p>
                <p style="color: green;">
                    <strong>Discount Applied (<?php echo $_SESSION['coupon_code']; ?>): -<?php echo $discount; ?>%</strong>
                </p>
                <h2 style="margin-top: 10px;">Total: $<?php echo number_format($final_price, 2); ?></h2>
            <?php else: ?>
                <h2>Total: $<?php echo number_format($game['price'], 2); ?></h2>
            <?php endif; ?>
        </div>

        <?php if(!isset($discount) || $discount == 0): ?>
            <div style="background: #38384ada; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px dashed #ccc;">
                <form action="index.php?action=applyCoupon" method="POST" style="margin: 0; box-shadow: none; background: transparent; padding: 0;">
                    <input type="hidden" name="game_id" value="<?php echo $game['id']; ?>">
                    
                    <label style="font-weight: bold;">Have a Coupon?</label>
                    <div style="display: flex; gap: 10px;">
                        <input type="text" name="coupon_code" placeholder="Enter code (e.g. SAVE10)" required style="padding: 10px; width: 200px;">
                        <button type="submit" style="background: #34495e; padding: 10px 20px;">Apply</button>
                    </div>

                    <?php if(isset($_GET['error']) && $_GET['error'] == 'invalid_coupon'): ?>
                        <p style="color: red; margin-top: 5px; font-size: 0.9em;">❌ Invalid Coupon Code</p>
                    <?php endif; ?>
                    
                    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'coupon_valid'): ?>
                        <p style="color: green; margin-top: 5px; font-size: 0.9em;">✅ Coupon Applied!</p>
                    <?php endif; ?>
                </form>
            </div>
        <?php endif; ?>

        <div style="background: #38384ada; padding: 20px; border-radius: 8px;">
            <h3>Select Payment Method</h3>
            <form action="index.php?action=confirm_purchase" method="POST" style="box-shadow: none; padding: 0;">
                <input type="hidden" name="game_id" value="<?php echo $game['id']; ?>">
                <input type="hidden" name="amount" value="<?php echo isset($final_price) ? $final_price : $game['price']; ?>">

                <label style="display:block; margin: 10px 0; cursor: pointer;">
                    <input type="radio" name="payment_method" value="bkash" required> 
                    <img src="https://logos-download.com/wp-content/uploads/2022/01/BKash_Logo_icon.png" style="height: 20px; vertical-align: middle;"> Bkash
                </label>
                
                <label style="display:block; margin: 10px 0; cursor: pointer;">
                    <input type="radio" name="payment_method" value="nagad" required> 
                    <img src="https://download.logo.wine/logo/Nagad/Nagad-Logo.wine.png" style="height: 20px; vertical-align: middle;"> Nagad
                </label>
                
                <label style="display:block; margin: 10px 0; cursor: pointer;">
                    <input type="radio" name="payment_method" value="card" required> 
                    💳 Credit Card (Visa/Mastercard)
                </label>
                
                <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
                    <label>Account / Card Number</label>
                    <input type="text" placeholder="XXXX-XXXX-XXXX-XXXX" required style="width: 100%; padding: 10px; margin-bottom: 10px;">
                    
                    <label>PIN / CVV</label>
                    <input type="password" placeholder="***" required style="width: 100px; padding: 10px;">
                </div>

                <br>
                <button type="submit" style="background: #27ae60; width: 100%; font-size: 1.2em; padding: 15px;">
                    Confirm Payment ($<?php echo number_format(isset($final_price) ? $final_price : $game['price'], 2); ?>)
                </button>
            </form>
        </div>

    </div>
</body>
</html>