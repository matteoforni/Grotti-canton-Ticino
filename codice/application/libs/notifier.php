<?php

class Notifier{

    function __construct()
    {   
        // Start session if it's not active
        if(session_status() != PHP_SESSION_ACTIVE){
            session_start();
        }

        // Create session variable if not exists
        if(!(isset($_SESSION["notifier"]))){
            $_SESSION["notifier"] = array();
        }
    }

    public function add(String $text){
        // Add element at the end of the array
        array_push($_SESSION["notifier"], $text);
    }

    public function add_all(array $array){
        foreach($array as $data){
            self::add($data);
        }
    }

    public function remove(int $index){
        // Remove element and re-index values
        unset($_SESSION["notifier"][$index]);
        $_SESSION["notifier"] = array_values($_SESSION["notifier"]);
    }

    public function clear(){
        // Secure clear
        unset($_SESSION["notifier"]);
        $_SESSION["notifier"] = array();
    }

    public function getNotifications(): array{
        return $_SESSION["notifier"];
    }
}