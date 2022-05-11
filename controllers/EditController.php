<?php  
namespace Controllers;

class EditController{
    public function index(){
        $id = $_GET['edit'];
        $verificar = \MySql::connect()->prepare("SELECT * FROM usuarios WHERE id = $id");
        $verificar->execute();

        if($verificar->rowCount() == 1){
            if(isset($_GET['edit'])){
                $dados = $verificar->fetch();
                \Views\MainView::render('edit',$dados);
            }else{
                echo '<script>location.href="home"</script>';
            }
        }else{
            echo '<script>location.href="home"</script>';
        }
    }
}