<?php 


$event = isset($event) ? $event: [];

?>


<div class="main-container">

<form action="" class="form" method="post" enctype="multipart/form-data">

<?php if (isset($event) && $event != []): ?>
    <input type="hidden" name="event_id" value="<?= $event["id"]  ?>">
<?php endif; ?>
    <div class="form-title">
        Event Form
    </div>

    <div class="form-input">
        <label for="title">Title: </label>
        <input type="text" name="title" required value="<?= isset($event["title"]) ? $event['title']: '' ?>">
    </div>

    <div class="form-input">
        <label for="category">Category: </label>
        <select name="category"  required >
            <option value="Music" <?= isset($event["category"]) == "Music" ? "selected" : "" ?>>Music</option>
            <option value="Festival" <?= isset($event["category"]) == "Festival" ? "selected" : "" ?>>Festival</option>
            <option value="Seminar" <?= isset($event["category"]) == "Seminar" ? "selected" : "" ?>>Seminar</option>
        </select>
    </div>
    
    <div class="form-input">
        <label for="ticket_price">Ticket Price: </label>
        <input type="number" name="ticket_price" required value="<?= isset($event["ticket_price"]) ? $event['ticket_price']: '' ?>">
    </div>

    <div class="form-input">
        <label for="description">Description: </label>
        <textarea name="description" required >
<?= isset($event['description']) ? $event['description']: '' ?>
        </textarea>
    </div>

    <div class="form-input">
        <label for="image">image: </label>
        <input type="file"  name="image"  >
    </div>

    <div>
        <button type="submit">Submit</button>
    </div>

    <label for="email"></label>
</form>

</div>