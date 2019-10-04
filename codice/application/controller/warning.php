<?php

class Warning
{
    public function index()
    {
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
        }
        //Show warning page
        ViewLoader::load("_templates/header_base");
        ViewLoader::load("warning/index");
        ViewLoader::load("_templates/footer");
    }
}