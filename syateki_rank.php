<?php
$dsn = 'mysql:dbname=game;host=localhost;port=3306;charset=utf8';
$user='uk';
$password='1234';



class Json {
    public $score1;
    public $score2;
    public $score3;
    function __construct($score1,$score2,$score3) {
        $this->score1=$score1;
        $this->score2=$score2;
        $this->score3=$score3;
    }
}
try{
    $dbh = new PDO($dsn,$user,$password);
        // SQL文をセット
 
    $sql='select score1 from status order by score1 desc limit 0,';
    $stmt=$dbh->query($sql);
    $i=1;
    foreach ($stmt as $data)
    {
        ${"score".$i}=$data["syateki_score"];
        $i=$i+1;
    }
    $sql->execute();
    $all = $sql->fetchAll();
    $Jsond= new Json($score1,$score2,$score3);
    header('Content-type: application/json');
    echo json_encode($Jsond);
    }catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}
?>
