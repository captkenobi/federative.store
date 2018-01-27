<?php

class Auth {
    public static function isAuth()
    {
        return $_SESSION["auth"] > 0 ? true : false;
    }
    
    public static function setAuth()
    {
        $_SESSION["auth"] = 1;
    }
    
    public static function removeAuth()
    {
        unset($_SESSION["auth"]);
    }
}
