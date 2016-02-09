<?php
class AnsibleHost {
    public $hostname = "";
    public $ipaddress = "";
    public $groups = array();
    public $vars = array();
    public $fact = null;
    
    public function __construct($hostname,$ipaddress=null,$groups=null,$vars=null){
        $this->hostname = $hostname;
        if($ipaddress===null){
            $this->ipaddress = gethostbyname($ipaddress);
        }else{
            $this->ipaddress = $ipaddress;
        }
        if($groups===null){
            $this->groups = array();
        }else{
            $this->groups = $groups;
        }
        if($vars===null){
            $this->vars = array();
        }else{
            $this->vars = $vars;
        }
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
        $handle = fopen($files[$i], 'r');
        $this->fact = json_decode(fread($handle, filesize($files[$i])),true);
        fclose($handle);
    }
}
?>