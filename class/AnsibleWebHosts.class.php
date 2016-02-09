<?php
class AnsibleWebHosts {
    private $hostsfile = "/etc/ansible/hosts";
    private $hosts = array();
    
    public function __construct($hostsfile){
        $this->hostsfile = $hostsfile;
        $this->parseHostsFile();
    }
    
    public function getHosts(){
        return $this->hosts;
    }
    
    private function parseHostsFile() {
        $hosts_file = fopen($this->hostsfile , "r");
        $group = '';
        if($hosts_file){
            while ($line = fgets($hosts_file)){
                $line = trim($line);
                if($line === '' or $line{0} === ';' or $line{0} === '#')continue;
                preg_match('/^\[(.*)\]$/',$line,$match);
                if(count($match)>0){               //group
                    $group = $match[1];
                }else{                             //host
                    $this->addHost($this->readLine($line),$group);
                }
            }
        }
    }
    
    private function addHost($host,$group){
        $exist = false;
        for($i=0;$i<count($this->hosts);$i++){
            if($this->hosts[$i]["hostname"]===$host["hostname"]){
                $exist = true;
                if(array_search($group,$this->hosts[$i]["groups"])===false){
                    $this->hosts[$i]["groups"][] = $group;
                }
            }
        }
        if(!$exist){
            if($group === 'all'){
                $host["groups"]=array( 0 => 'all');
            }else{
                $host["groups"]=array( 0 => 'all' , 1 => $group );
            }
            $this->hosts[] = $host;
        }
    }
    
    private function readLine($line){
        $splitarray = split(" ",$line);
        $retarray = array();
        $retarray["hostname"] = array_shift($splitarray);
        $retarray["ipaddress"] = gethostbyname($retarray["hostname"]);
        return $retarray;
        //今はhostだけ
    }
}


?>