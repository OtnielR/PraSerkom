<?php 

$action = isset($action) ? $action : "";


?>



<div class="main-container">

<form action="" class="form" method="post">
    <div class="form-title">
        User Form
    </div>

    <?php if ($action == "register"): ?>
    <div class="form-input">
        <label for="username">Username: </label>
        <input type="text" name="username" required>
    </div>
    <?php endif; ?>

    <div class="form-input">
        <label for="email">Email: </label>
        <input type="text" name="email" required>
    </div>
    
    <div class="form-input">
        <label for="password">Password: </label>
        <input type="password" name="password" required>
    </div>

    <div>
        <button type="submit">Submit</button>
    </div>

    <label for="email"></label>
</form>

</div>