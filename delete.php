
<?php
$dsn = 'mysql:dbname=game;host=localhost;port=3306;charset=utf8';
$user='uk';
$password='1234';


try{
    $dbh = new PDO($dsn,$user,$password);
    $sql = 
    $dbh->prepare('delete from status;');
    $sql->execute();
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}



?>


