<?php  

session_start();

$autoload = function($class){
    include($class.'.php');
};

spl_autoload_register($autoload);
$aplication = new Aplication();
$aplication->run();

function pegarPost($post){
    if(isset($_POST[$post])){
        echo $_POST[$post];
    }
}
?>
