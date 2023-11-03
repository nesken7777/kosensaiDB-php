
<?php
$dsn = 'mysql:dbname=game;host=localhost;port=1234;charset=utf8';
$user='uk';
$password='1234';

class Json {
    public $id;
    public $power;
    public $stamina;
    public $score1;
    public $score2;
    public $speed;
    public $syateki_score;
    public $syateki_stage;
    function __construct($id,$power,$stamina,$score1,$score2,$speed,$syateki_score,$syateki_stage) {
        $this->id = $id;
        $this->power = $power;
        $this->stamina = $stamina;
        $this->score1 = $score1;
        $this->score2 = $score2;
        $this->speed = $speed;
        $this->syateki_score=$syateki_score;
        $this->syateki_stage=$syateki_stage;
    }
}


try{
    
    $power=$_GET['power'] ?? 0;
    $score1=$_GET['score1'] ?? 0;
    $score2=$_GET['score2'] ?? 0;
    $speed=$_GET['speed'] ?? 0;
    $stamina=$_GET['stamina'] ?? 0;
    $syateki_score=$_GET['syateki_score'] ?? 0;
    $idm=$_GET['idm'] ?? 0;
    $syateki_stage=$_GET['syateki_stage'] ?? 0;
    $dbh = new PDO($dsn,$user,$password);


    $sql = 
    $dbh->prepare('select * from status where idm = ? AND exist=1');
    $sql->bindValue(1,$idm);
    $sql->execute();
    $all = $sql->fetchAll();
        foreach ($all as $data)
        {

            $Jsond=new Json(
                $data['id'],
                $data['power'],
                $data['stamina'],
                $data['score1'],
                $data['score2'],
                $data['speed'],
                $data['syateki_score'],
                $data["syateki_stage"]
            );
        
        }
    // SQL文をセット
    $stmt = $dbh->prepare(' UPDATE status SET power=:power, score1=:score1, score2=:score2,speed=:speed,stamina=:stamina,syateki_score=:syateki_score ,syateki_stage=:syateki_stage where id =:id ');
    
    
    $stmt->bindValue(':id',$Jsond->id);    
    $stmt->bindValue(':power', (int)$Jsond->power + (int)$power);
    $stmt->bindValue(':score1',  (int)$score1);
    $stmt->bindValue(':score2', (int)$score2);
    $stmt->bindValue(':speed', (int)$Jsond->speed + (int)$speed);
    $stmt->bindValue(':stamina', (int)$Jsond->stamina + (int)$stamina);
    $stmt->bindValue(':syateki_score', (int)$syateki_score);
    $stmt->bindValue(':syateki_stage', (int)$syateki_stage);
        // SQL実行
    $stmt->execute();
            
        
        
    
    //jsonとして出力

}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}


$dbh = null;
?>


