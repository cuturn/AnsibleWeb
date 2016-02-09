<?php
require_once(dirname(__FILE__) . "/../include/Spyc.php");

class AnsiblePlaybook {
    public $playbookname = "";
    public $path = "";
    public $hosts = "";
    public $roles = array();
    public $tasknum = 0;
    
    public function readFile($path){
        $this->playbookname = basename($path);
        $this->path = $path;
        $yaml = Spyc::YAMLLoad($path);
        if($yaml){
            if(isset($yaml[0]["hosts"]))$this->hosts = $yaml[0]["hosts"];
            if(isset($yaml[0]["roles"])){
                for($i=0;$i<count($yaml[0]["roles"]);$i++){
                    if(is_array($yaml[0]["roles"])){
                        $this->roles[] = $yaml[0]["roles"][$i]["role"];
                    }else{
                        $this->roles[] = $yaml[0]["roles"][$i];
                    }
                }
            }else{
                $this->roles = array();
            }
            if(isset($yaml[0]["tasks"]) && is_array($yaml[0]["tasks"])){
                $this->tasknum = count($yaml[0]["tasks"]);
            }
        }
    }
}
?>