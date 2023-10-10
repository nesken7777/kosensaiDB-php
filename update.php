
<?php
$dsn = 'mysql:dbname=game;host=localhost;port=1234;charset=utf8';
$user='uk';
$password='1234';

class Json {
    public $id;
    public $power;
    public $luck;
    public $stamina;
    public $score1;
    public $score2;
    public $speed;


    function __construct($id,$score1,$score2,$speed,$stamina,$luck,$power) {
        $this->id = $id;
        $this->power = $power;
        $this->stamina = $stamina;
        $this->score1 = $score1;
        $this->score2 = $score2;
        $this->speed = $speed;
        $this->luck = $luck;
    }
}


try{
    $power=$_GET['power'];
    $score1=$_GET['score1'];
    $score2=$_GET['score2'];
    $speed=$_GET['speed'];
    $stamina=$_GET['stamina'];
    $luck=$_GET['luck'];
    $id=$_GET['id'];

    
    $dbh = new PDO($dsn,$user,$password);


        
   
        // SQL文をセット
    $stmt = $dbh->prepare(' UPDATE status SET power=:power, score1=:score1, score2=:score2,speed=:speed,stamina=:stamina,luck=:luck where id = :id');
     
        // 値をセット
    $stmt->bindValue(':id', $id);    
    $stmt->bindValue(':power', $power);
    $stmt->bindValue(':score1', $score1);
    $stmt->bindValue(':score2', $score2);
    $stmt->bindValue(':speed', $speed);
    $stmt->bindValue(':stamina', $stamina);
    $stmt->bindValue(':luck', $luck);

     
        // SQL実行
    $stmt->execute();
            
        
        
    
    //jsonとして出力
  

}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}


$dbh = null;
?>


