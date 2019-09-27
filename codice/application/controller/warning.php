<?php
class warning
{
    public function index()
    {
        //Show index page
        ViewLoader::load("_templates/header_base");
        ViewLoader::load("warning/db");
        ViewLoader::load("_templates/footer");
    }
}