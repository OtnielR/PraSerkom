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
            <th>Status</th>
        </thead>
        <tbody>
            <?php $index = 0; ?>
            
            <?php while($order = $orders->fetch_assoc()): ?>

                <?php $index++; ?>
                <tr>
                    <td><?= $index ?></td>
                    <td><?= $order["customer_name"] ?></td>
                    <td><?= $order["customer_email"] ?></td>
                    <td>Rp. <?= $order["total_price"] ?></td>
                    <td>
                        <form action="" method="post">

                    <select name="status" required onchange="this.form.submit()">
                        <option value="Pending" <?= $order["status"] == "Pending" ? "selected" : "" ?>>Pending</option>
                        <option value="Confirmed" <?= $order["status"] == "Confirmed" ? "selected" : "" ?>>Confirmed</option>
                        <option value="Cancelled" <?= $order["status"] == "Cancelled" ? "selected" : "" ?>>Cancelled</option>
                    </select>
                    <input type="hidden" name="order_id" value="<?= $order["id"] ?>">

                    </form>
                </td>
                        </tr>

            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div>No Events Found</div>

    <?php endif; ?>
</div>
