<?php
$dsn = 'mysql:dbname=game;host=localhost;port=3306;charset=utf8';
$user='uk';
$password='1234';



class Json {
    public $id;
    function __construct($id) {

        $this->id=$id;
    }
}
try{
    $name=$_GET['name'];

    
    $dbh = new PDO($dsn,$user,$password);

    // SQL文をセット
    $stmt = $dbh->prepare('INSERT INTO status (power,score1 , score2, speed,stamina,luck,name) VALUES(:power,:score1 , :score2, :speed,:stamina,:luck,:name)');
 
    // 値をセット
    $stmt->bindValue(':power', 0);
    $stmt->bindValue(':score1', 0);
    $stmt->bindValue(':score2', 0);
    $stmt->bindValue(':speed', 0);
    $stmt->bindValue(':stamina', 0);
    $stmt->bindValue(':luck', 0);
    $stmt->bindValue(':name', $name);

 
    // SQL実行
    $stmt->execute();
    $stmt = $dbh->prepare("SELECT  id
    FROM status
    ORDER BY id DESC
    limit 0,1
    ;");

    $stmt->execute();
    $all = $stmt->fetchAll();
    foreach ($all as $data)
    {

        $id=$data["id"];
    
    }
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}


$dbh = null;
?>
