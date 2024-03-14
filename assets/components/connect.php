<?php 
try{
    $db_name= 'mysql:dbname=home_db;host=localhost';
    $user_name= 'root';
    $password = 'HTMLCSS1728';
    

$conn= new PDO($db_name, $user_name, $password);

function create_unique_id (){
    $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $char_len = strlen($char);
    $rand_str = '';
    for ($i = 0; $i < 20; $i++) {
        $rand_str .= $char[mt_rand(0, $char_len - 1)];
      }
    return $rand_str;
}

}catch(PDOException $e){
    echo 'Connection faild!'. $e->getMessage();
}

?>