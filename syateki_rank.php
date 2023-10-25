<?php
$dsn = 'mysql:dbname=game;host=localhost;port=3306;charset=utf8';
$user='uk';
$password='1234';



class Json {
    public $score1_1;
    public $score2_1;
    public $score3_1;
    public $score1_2;
    public $score2_2;
    public $score3_2;
    public $score1_3;
    public $score2_3;
    public $score3_3;
    function __construct($score1_1,$score1_2,$score1_3,$score2_1,$score2_2,$score2_3,$score3_1,$score3_2,$score3_3) {
        $this->score1_1=$score1_1;
        $this->score1_2=$score1_2;
        $this->score1_3=$score1_3;
        $this->score2_1=$score2_1;
        $this->score2_2=$score2_2;
        $this->score2_3=$score2_3;
        $this->score3_1=$score3_1;
        $this->score3_2=$score3_2;
        $this->score3_3=$score3_3;
    }
}
try{
    $dbh = new PDO($dsn,$user,$password);
        // SQL文をセット
    $sql='select syateki_score from status where syateki_stage = 1 order by syateki_score desc limit 0,3 ';
    $stmt=$dbh->query($sql);
    $i=1;
    foreach ($stmt as $data)
    {
        ${"score1_".$i}=$data["syateki_score"];
        $i=$i+1;
    }
    $sql='select syateki_score from status where syateki_stage = 2 order by syateki_score desc limit 0,3 ';
    $stmt=$dbh->query($sql);
    $i=1;
    foreach ($stmt as $data)
    {
        ${"score2_".$i}=$data["syateki_score"];
        $i=$i+1;
    }
    $sql='select syateki_score from status where syateki_stage = 3 order by syateki_score desc limit 0,3 ';
    $stmt=$dbh->query($sql);
    $i=1;
    foreach ($stmt as $data)
    {
        ${"score3_".$i}=$data["syateki_score"];
        $i=$i+1;
    }
    $Jsond= new Json($score1_1,$score1_2,$score1_3,$score2_1,$score2_2,$score2_3,$score3_1,$score3_2,$score3_3);
    header('Content-type: application/json');
    echo json_encode($Jsond);
    }catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}
?>
