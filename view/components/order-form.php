<?php

$orders = isset($orders) ? $orders : []

?>


<div class="order-container">
    <form action="" class="form" method="post">
        <div class="form-title">
            Order Form
        </div>

        <div class="order-details">
            <?php foreach ($orders as $key => $value): ?>
                <div class="details">
                    <img src="<?= __BASEURL__ . $value['image'] ?>" alt="">
                    <div>
                        <b>
                            <?= $value['title'] ?>
                        </b>

                        <p>
                            Rp.
                            <?= $value["ticketPrice"] ?> x
                            <?= $value["quantity"] ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
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

        <div>
            <button type="submit">Submit</button>
        </div>

        <label for="email"></label>
    </form>

</div>
