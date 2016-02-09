<?php
class AnsibleWebDB
{
    public $pdo ;
    public function __construct(){
        try{
            $this->pdo = new PDO("sqlite:" . dirname(__FILE__) . "/../db/ansible.db");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(Exception $e){
            echo $e->getMessage() . PHP_EOL;
        }
    }
    
    public function getPlaybooks(){
        try {
            $sql = "SELECT id,name,path FROM playbooks";
            $stmt = $this->pdo->query($sql);
            $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
        return $ret;
    }
    
    public function addPlaybooks($arr){
        try{
           $this->pdo->exec("BEGIN DEFERRED;");
           $sql = "INSERT INTO playbooks (name,path) VALUES (:name,:path) ";
            $stmt = $this->pdo->prepare($sql);
            for($i=0;$i<count($arr);$i++){
                $stmt->bindParam(":name",basename($arr[$i]));
                $stmt->bindParam(":path",$arr[$i]);
                $stmt->execute();
            }
            $this->pdo->exec("COMMIT;");
        }catch (Exception $e) {
            $this->pdo->exec("ROLLBACK;");
            echo $e->getMessage() . PHP_EOL;
        }
    }
    
    public function getHosts($query=null){
         try {
            $sql = "SELECT id,hostname,ipaddress,variables FROM hosts";
            $stmt = $this->pdo->query($sql);
            $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
        return $ret;
    }
    
    public function addHosts($hosts){
        try{
            $this->pdo->exec("BEGIN DEFERRED;");
            $sql = "INSERT INTO hosts (hostname,ipaddress,variables) VALUES (:hostname,:ipaddress,:variables) ";
            $stmt = $this->pdo->prepare($sql);
            $variables = "";
            for($i=0;$i<count($hosts);$i++){
                $stmt->bindParam(":hostname",$hosts[$i]['hostname']);
                $stmt->bindParam(":ipaddress",$hosts[$i]['ipaddress']);
                foreach($hosts[$i]['variables'] as $vkey=>$value){
                    $variables .= $vkey . "='" . $value . "' ";
                }
                $stmt->bindParam(":variables",$variables);
                $stmt->execute();
            }
            $this->pdo->exec("COMMIT;");
        }catch (Exception $e) {
            $this->pdo->exec("ROLLBACK;");
            echo $e->getMessage() . PHP_EOL;
        }
    }
    
}
?>