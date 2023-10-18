
<?php
$dsn = 'mysql:dbname=game;host=localhost;port=3306;charset=utf8';
$user='uk';
$password='1234';

class Json {
    public $id;
    public $power;
    public $syateki_score;
    public $stamina;
    public $score1;
    public $score2;
    public $speed;
    public $name;


    function __construct($id,$score1,$score2,$speed,$stamina,$syateki_score,$power,$name) {
        $this->id = $id;
        $this->power = $power;
        $this->stamina = $stamina;
        $this->score1 = $score1;
        $this->score2 = $score2;
        $this->speed = $speed;
        $this->syateki_score = $syateki_score;
        $this -> name=$name;
    }
}


try{
    $id=$_GET['id'];
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
                $data['syateki_score'],
                $data['power'],
                $data['name']
            );
        
        }
    
    //jsonとして出力
    header('Content-type: application/json');
    echo json_encode($Jsond);
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}


$dbh = null;
?>


