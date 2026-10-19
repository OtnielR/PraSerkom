<?php



$event = isset($event) ? $event : [];

?>

<div class="card-event">
    <div class="card-event-image">
        <img src="<?= __BASEURL__ . $event["image"] ?>" alt="">
    </div>

<div>
    <div>
    <h3><?= $event["title"] ?></h3>
    <h4><?= $event["category"] ?></h4>
    <p>Rp. <?= $event["ticket_price"] ?></p>
</div>
<br>
    <div>
            <p><?= $event["description"] ?></p>
    <div>
        <br>
        <form action="" method="get">
            <input type="hidden" name="event_id" value="<?= $event["id"] ?>">
            <input type="hidden" name="title"  value="<?= $event["title"] ?>">
            <input type="hidden" name="ticket_price"  value="<?= $event["ticket_price"] ?>">
            <input type="hidden" name="image"  value="<?= $event["image"] ?>">

            <div class="form-input button-container">
            <button type="submit">Order</button>
</div>

        </form>

    </div>
</div>

</div>

</div>