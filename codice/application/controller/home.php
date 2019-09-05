<?php
class Home
{
    public function index()
    {
        //Show index page
        ViewLoader::load("_templates/header");
        ViewLoader::load("home/index");
        ViewLoader::load("_templates/footer");
    }
}
