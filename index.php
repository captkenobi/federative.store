<?php

define("ROOT", __DIR__);
require_once ROOT . "/core/Router.php";
require_once ROOT . "/core/DataBase.php";
require_once ROOT . "/core/Auth.php";



Router::get("^$", function($request, $response) {
   $context = array(
       "title" => "Домашняя страница",
   );
   $response->render("home", "standart_layout", $context);
});




Router::get("^auth/login$", function($request, $response){
    session_start();

    if (Auth::isAuth())
        die(header("Location: /root"));
    
    $context = array(
      "title" => "Вход"  
    );
    
    $response->render("auth/signin", "auth/auth_layout", $context);
});

Router::post("^auth/login", function($request, $response){
    session_start();
    
    $login = $_POST["login"];
    $password = $_POST["password"];
    
    $db = DataBase::createConnection();
    $stmt = $db->prepare("SELECT login, password FROM admins WHERE login = ?"); 
    $stmt->execute(array($login));
    
    $data = $stmt->fetch(PDO::FETCH_LAZY);
    
    if (!$data)
    {
        $_SESSION["errors"]["login"] = "Неверный логин";
        die(header("Location: /auth/login"));
    }
    else
    {
        if (password_verify($password, $data["password"]))
        {
            Auth::setAuth();
            die(header("Location: /root"));
        }
        else
        {
            $_SESSION["errors"]["password"] = "Неверный пароль";
            die(header("Location: /auth/login"));
        }
    }
});

Router::get("^auth/logout$", function($request, $response) {
    session_start();

    Auth::removeAuth();
    die(header("Location: /auth/login"));
});




Router::get("^root$", function($request, $response){
   session_start();
   
   if (!Auth::isAuth())
       die(header("Location: /auth/login"));
   
   $context = array(
       "title" => "Администраторская панель"
   );
   
   $response->render("root/index", "root/root_layout", $context);
});

Router::get("^root/store/new$", function($request, $response){
    session_start();
    
    if (!Auth::isAuth())
        die(header("Location: /auth/login"));
    
    $response->text("Store product [NEW]");
});

Router::post("^root/store/new$", function($request, $response){
    session_start();
    
    if(!Auth::isAuth())
        die(header("Location: /auth/login"));
    
    /*
     * TODO : [CREATE]
     */
    
});

Router::get("^root/store/(?P<id>[0-9]+)$", function($request, $response){
    session_start();
    
    if (!Auth::isAuth())
        die(header("Location: /auth/login"));
    
    $response->debug($request["params"]);
});

Router::post("^root/store/(?P<id>[0-9]+)/delete$", function($request, $response){
    session_start();
    
    if (!Auth::isAuth())
        die(header("Location: /auth/login"));
    
    /*
     * TODO : [DELETE]
     */
});

Router::run();