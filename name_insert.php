<?php
$dsn = 'mysql:dbname=game;host=localhost;port=1234;charset=utf8';
$user='uk';
$password='1234';

try{
    $name=urldecode($_GET['name']);
    $idm=$_GET["idm"];
    $dbh = new PDO($dsn,$user,$password);
    $stmt = $dbh->prepare('SELECT COUNT(*) from status WHERE idm=:idm AND exist=1');
    $stmt->$idm->bindValue(":idm",$idm);
    $sql->execute();
    $all = $sql->fetchAll();
    // SQL文をセット
    $stmt = $dbh->prepare('INSERT INTO status (power,score1 , score2, speed,stamina,syateki_score,syateki_stage,name,idm,exist) 
    VALUES(:power,:score1 , :score2, :speed,:stamina,:syateki_score,:syateki_stage,:name,:idm,:exist)');
    // 値をセット
    $stmt->bindValue(':power', 0);
    $stmt->bindValue(':score1', 0);
    $stmt->bindValue(':score2', 0);
    $stmt->bindValue(':speed', 0);
    $stmt->bindValue(':stamina', 0);
    $stmt->bindValue(':syateki_score', 0);
    $stmt->bindValue(':syateki_stage', 0);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':idm', $idm);
    $stmt->bindValue(':exist', 1);
    $stmt->execute();
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}
$dbh = null;
?>
