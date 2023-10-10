<?php
$dsn = 'mysql:dbname=game;host=localhost;port=3306;charset=utf8';
$user='uk';
$password='1234';



class Json {
    public $rank;
    function __construct($rank) {
        $this->rank=$rank;
    }
}
try{
    $id=$_GET['id'];
    $dbh = new PDO($dsn,$user,$password);
    $sql = $dbh->prepare('SELECT
    RANKED.SCORE_RANK
FROM
    (
    SELECT
        RANK() OVER(
    ORDER BY
        score1
    DESC
    ) AS SCORE_RANK,
    id
FROM
STATUS
        ) AS RANKED
    WHERE
        id = ? ');
    $sql->bindValue(1,$id);
    $sql->execute();
    $all = $sql->fetchAll();
    $Jsond= new Json($all[0]["SCORE_RANK"]);
    header('Content-type: application/json');
    echo json_encode($Jsond);
    }catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}
?>
