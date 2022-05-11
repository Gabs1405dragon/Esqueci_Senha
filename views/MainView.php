<?php  
namespace Views;

class MainView{
    public static function render($fileName,$dados = null){
        include('pages/'.$fileName.'.php');
    }
}