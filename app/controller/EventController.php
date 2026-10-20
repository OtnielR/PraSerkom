<?php


require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../core/config.php");
require_once(__DIR__ . "/../core/database.php");
require_once(__DIR__ . "/../core/auth.php");
require_once(__DIR__ . "/../model/User.php");
require_once(__DIR__ . "/../model/Event.php");
require_once(__DIR__ . "/../utils/FileUtils.php");

class EventController extends Controller
{

    private Database $db;
    private User $userModel;

    private Event $eventModel;



    public function __construct()
    {
        $this->db = new Database();
        $this->userModel = new User($this->db);
        $this->eventModel = new Event($this->db);
    }

    public function create()
    {
        Auth::requireAuth();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = trim($_POST["title"]);
            $category = trim($_POST["category"]);
            $ticketPrice = trim($_POST["ticket_price"]);
            $description = trim($_POST["description"]);
            $image = null;

            $imageResponse = FileUtils::storeImage("image");

            if ($imageResponse["status"]) {
                $image = $imageResponse["path"];
            }

            $this->eventModel->create($title, $category, $ticketPrice, $description, $image);

            header("Location: " . __BASEURL__ . "/view/dashboard");
        }

        $this->view("components/event-form", []);
    }

    public function update()
    {
        Auth::requireAuth();
        $event = null;
        $eventId = null;

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $eventId = $_GET["event_id"];

            $event = $this->eventModel->getEventById($eventId);

            if (!$event) {
                header("Location: " . __BASEURL__ . "/view/dashboard/");
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = trim($_POST["title"]);
            $category = trim($_POST["category"]);
            $ticketPrice = trim($_POST["ticket_price"]);
            $description = trim($_POST["description"]);
            $eventId = trim($_POST["event_id"]);

            $event = $this->eventModel->getEventById($eventId);
            $image = $event["image"];

            $imageResponse = FileUtils::storeImage("image");

            if ($imageResponse["status"]) {
                $image = $imageResponse["path"];
            }

            $this->eventModel->update($eventId, $title, $category, $ticketPrice, $description, $image);

            header("Location: " . __BASEURL__ . "/view/dashboard");
        }


        $this->view("components/event-form", ["event" => $event]);
    }

    public function delete()
    {
        Auth::requireAuth();
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $eventId = $_GET["event_id"];

            $this->eventModel->delete($eventId);
        }

        header("Location: " . __BASEURL__ . "/view/dashboard");
    }
}
