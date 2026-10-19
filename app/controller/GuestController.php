<?php


require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../core/config.php");
require_once(__DIR__ . "/../core/database.php");
require_once(__DIR__ . "/../model/User.php");
require_once(__DIR__ . "/../model/Order.php");
require_once(__DIR__ . "/../model/OrderDetails.php");
require_once(__DIR__ . "/../model/Event.php");

class GuestController extends Controller {

    private Database $db;
    private User $userModel;

    private Event $eventModel;

    private Order $orderModel;

    private OrderDetail $orderDetailModel;

    public function __construct()
    {
        $this->db = new Database();
        $this->userModel = new User($this->db);
        $this->eventModel = new Event($this->db);
        $this->orderModel = new Order($this->db);
        $this->orderDetailModel = new OrderDetail($this->db);
    }

    public function index() {
        $events = $this->eventModel->getAll();

        $this->handleCart();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $eventId = $_SESSION["cart"]["event_id"];
            $title = $_SESSION["cart"]["title"];
            $ticket_price = $_SESSION["cart"]["ticket_price"];
            $customer_name = $_POST["customer_name"];
            $customer_email= $_POST["customer_email"];
            $quantity = $_POST["quantity"];

            $total_price = (int) ($ticket_price *  $quantity);

            $order_id = $this->orderModel->create($customer_name, $customer_email, $total_price);

            if ($order_id) {
                $this->orderDetailModel->create($order_id, $eventId, $quantity, $total_price);
            }

            unset($_SESSION["cart"]);


        }

        $this->view("components/header", ["title" => "Ticket Box", "subtitle" => "This was where you order a ticket for an event"]);

        echo "<div class='grid'>";

        while ($event = $events->fetch_assoc()) {
            $this->view("/components/event-card", ["event" => $event]);
        }

        echo "</div>";


        if (isset($_SESSION["cart"]["event_id"])) {
            $this->view("components/order-form", ["image" => $_SESSION["cart"]["image"], "title" => $_SESSION["cart"]["title"], "ticket_price" => $_SESSION["cart"]["ticket_price"]]);
        }

    }


    public function handleCart() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = [];
        }

        if (!isset($_GET["event_id"])) {
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $eventId = $_GET["event_id"];
            $title = $_GET["title"];
            $ticketPrice = $_GET["ticket_price"];
            $image = $_GET["image"];

            $_SESSION["cart"]["event_id"] = $eventId;
            $_SESSION["cart"]["title"] = $title;
            $_SESSION["cart"]["ticket_price"] = $ticketPrice;
            $_SESSION["cart"]["image"] = $image;

        }
    }
}