<?php

class Auth {

    public static function init() {
        if (session_status() == PHP_SESSION_NONE) {

        session_start();
        }

    }

    public  static function login(array $user) {
        self::init();
        $_SESSION["is_logged_in"] = true;
        $_SESSION["username"] = $user["username"];
        $_SESSION["email"] = $user["email"];
    }

    public static function check() {
        self::init();
        return isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"] == true;
    }

    public static function requireGuest() {
        self::init();

        if (self::check()) {
            header("Location: " . __BASEURL__ . "/dashboard");
            exit;
        }
    }

    public static function requireAuth() {
        self::init();

        if (!self::check()) {
            header("Location: " . __BASEURL__ . "/view/pages/login.php");
            exit;
        }
    }

    public static function logout(){
        self::init();
        $_SESSION = [];

        session_destroy();
    }
}