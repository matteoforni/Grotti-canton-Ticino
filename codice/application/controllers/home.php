<?php
namespace Controllers;
use Libs\ViewLoader as ViewLoader;
use Libs\Auth as Auth;

class Home
{
    public function index()
    {
      if(!Auth::isAuthenticated())
      {
        ViewLoader::load('home/index');
      }
      else {
        $this->home();
      }
    }

    public function home() {
      if(!Auth::isAuthenticated())
      {
        $this->index();
        exit;
      }
      else {
        ViewLoader::load('home/home');
      }
    }

    public function login() {
      Auth::auth();
      $this->home();
    }

    public function logout() {
      Auth::logout();
      $this->index();
    }
}
