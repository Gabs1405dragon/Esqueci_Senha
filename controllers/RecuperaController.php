<?php  
namespace Controllers;

class RecuperaController{
    public function index(){
        if(isset($_SESSION['nome'])){
            \Views\MainView::render('recupera');
        }else{
            header('location: home');
        }
        
    }
}