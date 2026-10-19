<?php

class Controller {

    public static function view(string $viewPath, array $datas) {
        extract($datas);

        require_once(__BASEPATH__ . "/view/partials/head.php");
        require_once(__BASEPATH__ . "/view/partials/nav.php");

        $filePath = __BASEPATH__ . "/view/{$viewPath}" . ".php";

        if (file_exists($filePath)) {
            require($filePath);
        } else {
            die("File with path {$filePath} doesnt exist");
        }
    }

    public function __destruct()
    {
    // require_once(__BASEPATH__ . "/view/partials/footer.php");
    }
}