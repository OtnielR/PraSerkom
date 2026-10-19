<?php


require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../core/config.php");
require_once(__DIR__ . "/../core/database.php");
require_once(__DIR__ . "/../core/auth.php");
require_once(__DIR__ . "/../model/User.php");
require_once(__DIR__ . "/../model/Event.php");
require_once(__DIR__ . "/../model/Order.php");
class DashboardController extends Controller {

    private Database $db;
    private User $userModel;

    private Event $eventModel;


    private Order $orderModel;

    public function __construct()
    {
        $this->db = new Database();
        $this->userModel = new User($this->db);
        $this->eventModel = new Event($this->db);
        
        $this->orderModel = new Order($this->db);
    }

    public function index() {
    Auth::requireAuth();

        $events = $this->eventModel->getAll();

        $this->view("components/header", ["title" => "Event List", "subtitle" => "This was where you see all the event that available "]);
        $this->view("components/event-table", ["events" => $events]);
    }

    public function orderList() {
    Auth::requireAuth();
        
    if ($_SERVER["REQUEST_METHOD"] == "POST")  {
        $status = trim($_POST["status"]);
        $orderId = trim($_POST["order_id"]);

        $this->orderModel->updateStatus($orderId, $status);

    }

        $orders = $this->orderModel->getAll();

        $this->view("components/header", ["title" => "Order List", "subtitle" => "This was where you see all the order that running"]);
        $this->view("components/order-table", ["orders" => $orders]);
    }



}