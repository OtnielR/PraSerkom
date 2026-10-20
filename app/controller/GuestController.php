<?php


require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../core/config.php");
require_once(__DIR__ . "/../core/database.php");
require_once(__DIR__ . "/../model/User.php");
require_once(__DIR__ . "/../model/Order.php");
require_once(__DIR__ . "/../model/OrderDetails.php");
require_once(__DIR__ . "/../model/Event.php");

class GuestController extends Controller
{

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

    public function index()
    {
        $events = $this->eventModel->getAll();

        $this->handleCart();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["cart"])) {
            $orders = $_SESSION["cart"];
            $customer_name = $_POST["customer_name"];
            $customer_email = $_POST["customer_email"];

            $total_price = 0;

            foreach ($orders as $key => $value) {
                $total_price += $value["quantity"] * $value["ticketPrice"];
            }

            $order_id = $this->orderModel->create($customer_name, $customer_email, $total_price);

            foreach ($orders as $key => $value) {
                $this->orderDetailModel->create($order_id, $key, $value["quantity"], $value["ticketPrice"] * $value["quantity"]);
            }
            unset($_SESSION["cart"]);

            header("Location: " . __BASEURL__);
        }

        $this->view("components/header", ["title" => "Ticket Box", "subtitle" => "This was where you order a ticket for an event"]);

        echo "<div class='grid'>";

        while ($event = $events->fetch_assoc()) {
            $quantity = isset($_SESSION["cart"][$event["id"]]) ? $_SESSION["cart"][$event["id"]]["quantity"] : 0;
            $this->view("/components/event-card", ["event" => $event, "quantity" => $quantity]);
        }

        echo "</div>";

        if (isset($_SESSION["cart"]) && $_SESSION["cart"] !== []) {
            $this->view("components/order-form", ["orders" => $_SESSION["cart"]]);
        }
    }


    public function handleCart()
    {
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
            $action = $_GET["action"];


            switch ($action) {
                case "add":
                    if (isset($_SESSION["cart"][$eventId]["quantity"]) && $_SESSION["cart"][$eventId]["quantity"] >= 1) {
                        $_SESSION["cart"][$eventId]["quantity"]++;
                    } else {
                        $_SESSION["cart"][$eventId]["quantity"] = 1;
                        $_SESSION["cart"][$eventId]["title"] = $title;
                        $_SESSION["cart"][$eventId]["ticketPrice"] = $ticketPrice;
                        $_SESSION["cart"][$eventId]["image"] = $image;
                    }
                    break;

                case "decrease":
                    if (isset($_SESSION["cart"][$eventId]["quantity"]) && $_SESSION["cart"][$eventId]["quantity"] > 1) {
                        $_SESSION["cart"][$eventId]["quantity"]--;
                    } else {
                        unset($_SESSION["cart"][$eventId]);
                    }
                    break;
            }

            header("Location: " . __BASEURL__);
        }
    }
}
