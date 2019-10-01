<?php


class Admin
{
    public function index()
    {
        //Show index page
        ViewLoader::load("_templates/header_admin");
        ViewLoader::load("admin/index");
        ViewLoader::load("_templates/footer");
    }
}