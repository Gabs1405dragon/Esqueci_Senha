<?php  
namespace Controllers;

class HomeController{
    public function index(){
        \Views\MainView::render('home');
    }
}