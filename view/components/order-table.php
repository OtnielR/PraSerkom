<?php

$orders = isset($orders) ? $orders : null;
?>

<div class="table-container">
    <?php if ($orders): ?>

        <table>
            <thead>
                <th>No</th>
                <th>Customer Name</th>
                <th>Customer Email</th>
                <th>Total Price</th>
                <th>Details</th>
                <th>Status</th>
            </thead>
            <tbody>
                <?php $index = 0; ?>

                <?php foreach ($orders as $key => $order): ?>
                    <?php $details = $order["details"]; ?>

                    <?php $index++; ?>
                    <tr>
                        <td>
                            <?= $index ?>
                        </td>
                        <td>
                            <?= $order["order"]["customer_name"] ?>
                        </td>
                        <td>
                            <?= $order["order"]["customer_email"] ?>
                        </td>
                        <td>Rp.
                            <?= $order["order"]["total_price"] ?>
                        </td>
                        <td>
                            <div class="order-details">
                                <?php while ($detail = $details->fetch_assoc()): ?>
                                    <li>
                                        <?= $detail["title"] . " x " . $detail["quantity"] ?>
                                    </li>

                                <?php endwhile; ?>
                            </div>
                        </td>
                        <td>
                            <form action="" method="post">

                                <select name="status" required onchange="this.form.submit()">
                                    <option value="Pending" <?= $order["order"]["status"] == "Pending" ? "selected" : "" ?>>Pending
                                    </option>
                                    <option value="Confirmed" <?= $order["order"]["status"] == "Confirmed" ? "selected" : "" ?>>Confirmed
                                    </option>
                                    <option value="Cancelled" <?= $order["order"]["status"] == "Cancelled" ? "selected" : "" ?>>Cancelled
                                    </option>
                                </select>
                                <input type="hidden" name="order_id" value="<?= $order['order']['id'] ?>">

                            </form>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div>No Events Found</div>

    <?php endif; ?>
</div>
