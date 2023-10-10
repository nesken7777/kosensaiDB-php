
<?php
$dsn = 'mysql:dbname=game;host=localhost;port=3306;charset=utf8';
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
    
    $power=$_GET['power'] ?? 0;
    $score1=$_GET['score1'] ?? 0;
    $score2=$_GET['score2'] ?? 0;
    $speed=$_GET['speed'] ?? 0;
    $stamina=$_GET['stamina'] ?? 0;
    $luck=$_GET['luck'] ?? 0;
    $id=$_GET['id'] ?? 0;

    
    $dbh = new PDO($dsn,$user,$password);


    $sql = 
    $dbh->prepare('select * from status where id = ?');
    $sql->bindValue(1,$id);
    $sql->execute();
    $all = $sql->fetchAll();
        foreach ($all as $data)
        {

            $Jsond=new Json(
                $data['id'],
                $data['score1'],
                $data['score2'],
                $data['speed'],
                $data['stamina'],
                $data['luck'],
                $data['power'],
                $data['name']
            );
        
        }
    
    
    // SQL文をセット
    $stmt = $dbh->prepare(' UPDATE status SET power=:power, score1=:score1, score2=:score2,speed=:speed,stamina=:stamina,luck=:luck where id = :id');
    
        // 値をセット
    $stmt->bindValue(':id',$id);    
    $stmt->bindValue(':power', $Jsond->power + $power);
    $stmt->bindValue(':score1',  $score1);
    $stmt->bindValue(':score2', $score2);
    $stmt->bindValue(':speed', $Jsond->speed + $speed);
    $stmt->bindValue(':stamina', $Jsond->stamina + $stamina);
    $stmt->bindValue(':luck', $Jsond->luck + $luck);

     
        // SQL実行
    $stmt->execute();
            
        
        
    
    //jsonとして出力
  

}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}


$dbh = null;
?>


