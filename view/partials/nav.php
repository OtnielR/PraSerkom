<?php 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<nav>

        <div>
            <a href="<?= __BASEURL__ ?>">Ticket Box</a>
        </div>
        <?php if (isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"] == true): ?>
        <div>
            <a href="<?= __BASEURL__ ?>/view/dashboard">Dashboard</a>
            <a href="<?= __BASEURL__ ?>/view/dashboard/event-form.php">Event Form</a>
            <a href="<?= __BASEURL__ ?>/view/dashboard/order-list.php">Order List</a>

        </div>
        <div>
            <a href="<?= __BASEURL__ ?>/view/pages/logout.php">Logout</a>
        </div>
        <?php else: ?>
        <div>
            <a href="<?= __BASEURL__ ?>/view/pages/login.php">Login</a>
        </div>
        <?php endif; ?>

</nav>