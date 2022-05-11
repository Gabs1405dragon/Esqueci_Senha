<?php 
 class MySql{
     private static $pdo;

     public static function connect(){
         if(is_null(self::$pdo)){
  try{
            self::$pdo = new PDO("mysql:dbname=teste;host=localhost;port=8634","root","sonw8634",array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
         }catch(Exception $e){
            echo '<div>Erro ao conectar.</div>';
         }
         }
         return self::$pdo;
       
         
     }
 }