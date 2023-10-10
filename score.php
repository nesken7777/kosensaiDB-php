
<?php
$dsn = 'mysql:dbname=game;host=localhost;port=3306;charset=utf8';
$user='uk';
$password='1234';

class Json {
    public $score1_1;
    public $score1_2;
    public $score1_3;
    public $score1_4;
    public $score1_5;
    public $score2_1;
    public $score2_2;
    public $score2_3;
    public $score2_4;
    public $score2_5;
    public $score1_1_name;
    public $score1_2_name;
    public $score1_3_name;
    public $score1_4_name;
    public $score1_5_name;
    public $score2_1_name;
    public $score2_2_name;
    public $score2_3_name;
    public $score2_4_name;
    public $score2_5_name;
    function __construct($score1_1,$score1_2,$score1_3,$score2_1,$score2_2,$score1_4,$score1_5,$score2_4,$score2_5,$score2_3 ,$score1_1_name,$score1_2_name,$score1_3_name,$score1_4_name,$score1_5_name,$score2_1_name,$score2_2_name,$score2_3_name,$score2_4_name,$score2_5_name) {

        $this->score1_1=$score1_1;
        $this->score1_2=$score1_2;
        $this->score1_3=$score1_3;
        $this->score1_4=$score1_4;
        $this->score1_5=$score1_5;
        $this->score2_1=$score2_1;
        $this->score2_2=$score2_2;
        $this->score2_3=$score2_3;
        $this->score2_4=$score2_4;
        $this->score2_5=$score2_5;
        $this->score1_1_name=$score1_1_name;
        $this->score1_2_name=$score1_2_name;
        $this->score1_3_name=$score1_3_name;
        $this->score1_4_name=$score1_4_name;
        $this->score1_5_name=$score1_5_name;
        $this->score2_1_name=$score2_1_name;
        $this->score2_2_name=$score2_2_name;
        $this->score2_4_name=$score2_4_name;
        $this->score2_5_name=$score2_5_name;
        $this->score2_3_name=$score2_3_name;
    }
}


try{
    
    $dbh = new PDO($dsn,$user,$password);
        // SQL文をセット
 
    $sql='select score1 from status order by score1 desc limit 0,5';
    $stmt=$dbh->query($sql);
    $i=1;
        foreach ($stmt as $data)
        {
            ${"score1_".$i}=$data["score1"];
            $i=$i+1;
            
        }
    $sql='select score2 from status order by score2 desc limit 0,5';
    $stmt=$dbh->query($sql);
    $i=1;
            foreach ($stmt as $data)
            {
                ${"score2_".$i}=$data["score2"];
                $i=$i+1;
                
            }
        //jsonとして出力
    $sql='select score2 from status order by score2 desc limit 0,5';
    $stmt=$dbh->query($sql);
    $i=1;
            foreach ($stmt as $data)
            {
                ${"score2_".$i}=$data["score2"];
                $i=$i+1;
                    
            }
    $sql='select name from status order by score1 desc limit 0,5';
    $stmt=$dbh->query($sql);
    $i=1;
            foreach ($stmt as $data)
            {
                ${"score1_".$i."_name"}=$data["name"];
                $i=$i+1;
                            
            }
    
    $sql='select name from status order by score2 desc limit 0,5';
    $stmt=$dbh->query($sql);
    $i=1;
        foreach ($stmt as $data){
            ${"score2_".$i."_name"}=$data["name"];
            $i=$i+1;
        }
    $Jsond=new Json($score1_1,$score1_2,$score1_3,$score2_1,$score2_2,$score1_4,$score1_5,$score2_4,$score2_5,$score2_3 ,$score1_1_name,$score1_2_name,$score1_3_name,$score1_4_name,$score1_5_name,$score2_1_name,$score2_2_name,$score2_3_name,$score2_4_name,$score2_5_name);
    header('Content-type: application/json');
    echo json_encode($Jsond);
        
    

}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}


$dbh = null;
?>


