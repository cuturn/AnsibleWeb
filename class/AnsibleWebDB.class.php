<?php
require_once(dirname(__FILE__) . "/AnsibleHost.class.php");
require_once(dirname(__FILE__) . "/AnsiblePlaybook.class.php");

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
    
    public function getPlaybook($id){
        try {
            $sql = "SELECT id,name,path FROM playbooks WHERE id=:id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":id",$id);
            $stmt->execute();
            $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
        $playbook = null;
        if($ret){
            $playbook = new AnsiblePlaybook();
            $playbook->id = $ret[0]["id"];
            $playbook->name = $ret[0]["name"];
            $playbook->path = $ret[0]["path"];
        }
        return $playbook;
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
    
    public function getHost($id){
         try {
            $sql = "SELECT id,hostname,ipaddress,variables FROM hosts WHERE id=:id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":id",$id);
            $stmt->execute();
            $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
        $host = null;
        if($ret){
            $host = new AnsibleHost();
            $host->id = $ret[0]["id"];
            $host->hostname = $ret[0]["hostname"];
            $host->ipaddress = $ret[0]["ipaddress"];
            $host->variables = split("," , $ret[0]["variables"]);
        }
        return $host;
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
    
    public function getPlayHistory(){
        try {
            $sql = "SELECT id,hostid,playbookid,date,ok,changed,unreachable,failed FROM playhistory ORDER BY id DESC";
            $stmt = $this->pdo->query($sql);
            $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
        return $ret;
    }
    
    public function addHistory($hid,$pid,$date=null,$ok=0,$changed=0,$unreachable=0,$failed=0){
        if($date===null){
            $date = new DateTime();
        }
        $datestr = $date->format("Y-m-d H:i:s");
        try{
            $this->pdo->exec("BEGIN DEFERRED;");
            $sql = "INSERT INTO playhistory (hostid,playbookid,date,ok,changed,unreachable,failed) VALUES ( :hid , :pid , :datestr , :ok , :changed , :unreachable , :failed ) ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":hid",$hid);
            $stmt->bindParam(":pid",$pid);
            $stmt->bindParam(":datestr",$datestr);
            $stmt->bindParam(":ok",$ok);
            $stmt->bindParam(":changed",$changed);
            $stmt->bindParam(":unreachable",$unreachable);
            $stmt->bindParam(":failed",$failed);
            $stmt->execute();
            $this->pdo->exec("COMMIT;");
        }catch (Exception $e) {
            $this->pdo->exec("ROLLBACK;");
            echo $e->getMessage() . PHP_EOL;
        }
    }
    
}
?>