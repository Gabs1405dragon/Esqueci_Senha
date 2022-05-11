<?php  
namespace Controllers;

class EsqueciController{
    public function index(){
        \Views\MainView::render('esqueci');
    }
}