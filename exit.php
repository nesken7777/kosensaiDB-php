<?php
$dsn = 'mysql:dbname=game;host=localhost;port=1234;charset=utf8';
$user='uk';
$password='1234';
try{
    $dbh = new PDO($dsn,$user,$password);
    $idm=$_GET['idm'] ?? 0;
    $stmt = $dbh->prepare(' UPDATE status SET exist=0 where idm =:idm AND exist=1 ');
    
    
    $stmt->bindValue(':idm',$idm);    

        // SQL実行
    $stmt->execute();
            
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}

