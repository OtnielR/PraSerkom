<?php


require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../core/config.php");
require_once(__DIR__ . "/../core/database.php");
require_once(__DIR__ . "/../core/auth.php");
require_once(__DIR__ . "/../model/User.php");

class AuthController extends Controller
{

    private Database $db;
    private User $userModel;


    public function __construct()
    {
        $this->db = new Database();
        $this->userModel = new User($this->db);
    }


    public function login()
    {
        Auth::requireGuest();
        $error = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = trim($_POST["email"]);
            $password = trim($_POST["password"]);

            $user = $this->userModel->getUserByEmail($email);

            if ($user) {
                if (password_verify($password, $user["password"])) {
                    Auth::login($user);

                    header("Location: " . __BASEURL__ . "/view/dashboard");
                }
            } else {

                $error = "User not found, password or email wrong";
            }
        }

        return $this->view("components/user-form", ["action" => "login", "error" => $error]);
    }

    public function logout()
    {
        Auth::logout();

        header("Location: " . __BASEURL__);
    }
}

