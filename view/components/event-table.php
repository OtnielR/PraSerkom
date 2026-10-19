<?php 

$events = isset($events) ? $events : null;
?>

<div class="table-container">
<?php if ($events): ?>
    
    <table>
        <thead>
            <th>No</th>
            <th>Title</th>
            <th>Category</th>
            <th>Ticket Price</th>
            <th>Description</th>
            <th>Image</th>
            <th>Aksi</th>
        </thead>
        <tbody>
            <?php $index = 0; ?>
            <?php while($event = $events->fetch_assoc()): ?>
                <?php $index++; ?>
                <tr>
                    <td><?= $index ?></td>
                    <td><?= $event["title"] ?></td>
                    <td><?= $event["category"] ?></td>
                    <td><?= $event["ticket_price"] ?></td>
                    <td><?= $event["description"] ?></td>
                    <td>
                        <img src="<?= __BASEURL__ .  $event["image"] ?>" alt="">
                    </td>
                    <td class="table-action">
                        <a href="<?= __BASEURL__ . "/view/dashboard/event-delete.php?event_id=" . $event["id"] ?>">Delete</a>

                        <a href="<?= __BASEURL__ . "/view/dashboard/event-update.php?event_id=" . $event["id"] ?>">Update</a>

                    </td>
                </tr>

            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div>No Events Found</div>

    <?php endif; ?>
</div>
