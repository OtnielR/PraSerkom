<?php 


?>


<div class="order-container">
<form action="" class="form" method="post">
    <div class="form-title">
        Order Form
    </div>

    <div class="order-details">
        <img src="<?= __BASEURL__ . $image ?>" alt="">
        <div>
            <b><?= $title ?></b>

            <p>Rp. <?=  $ticket_price ?>/ticket</p>
        </div>
    </div>

    <hr>

    <div class="form-input">
        <label for="customer_name">Customer Name: </label>
        <input type="text" name="customer_name" required>
    </div>

    <div class="form-input">
        <label for="customer_email">Customer Email: </label>
        <input type="email" name="customer_email" required>
    </div>
    
    <div class="form-input">
        <label for="quantity">Quantity: </label>
        <input type="number" name="quantity" required>
    </div>

    <div>
        <button type="submit">Submit</button>
    </div>

    <label for="email"></label>
</form>

</div>