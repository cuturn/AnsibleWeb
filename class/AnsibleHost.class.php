<?php
class AnsibleHost {
    public $id = 0;
    public $hostname = "";
    public $ipaddress = "";
    public $groups = array();
    public $vars = array();
    public $fact = null;
    
    public function __construct(){
        
    }
    
    public function toString(){
        $str = "";
        for($i=0;$i<count($groups);$i++){
            $str .= "[".$groups[$i]."]\n";
            $str .= $this->hostname . " " . join(" ",$vars);
        }
        return $str;
    }
    
    public function setFact($factpath){
        $handle = fopen($factpath."/".$this->hostname, 'r');
        $this->fact = json_decode(fread($handle, filesize($factpath."/".$this->hostname)),true);
        fclose($handle);
    }
    
    public function resolveIP(){
        $this->ipaddress = gethostbyname($hostname);
        return $this->ipaddress;
    }
}
?>