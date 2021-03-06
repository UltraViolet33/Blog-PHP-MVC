<?php

class Controller
{
    /**
     * view
     * load a view file
     * @return void
     */
    public function view($path, $data = [])
    {
        extract($data);

        if (file_exists("../app/view/" . $path . ".php")) {
            include "../app/view/" . $path . ".php";
        } else {
            include "../app/view/404.php";
        }
    }

    /**
     * loadModel
     * load a model file
     * @return object
     */
    public function loadModel($model)
    {
        if (file_exists("../app/model/" .  strtolower($model) . ".php")) {
            include "../app/model/" . strtolower($model) . ".php";
            return $a = new $model();
        }
        return false;
    }

    public function loadController($controller)
    {
        if (file_exists("../app/controller/" .  strtolower($controller) . ".php")) {
            include "../app/controller/" . strtolower($controller) . ".php";
            return $a = new $controller();
        }
        return false;
    }

    public function checkLogin()
    {
        if (!empty($_SESSION['user'])) {
            return true;
        }
        return false;
    }

    public function checkAdminLogin()
    {
        if (empty($_SESSION['user']) || $_SESSION['user']['isAdmin'] != 1) {
            header("Location: " . ROOT . "login");
            return;
        }
    }
}
