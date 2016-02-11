<?php
require_once("include/config.php");
$error = 0;
if(!isset($_REQUEST["pid"])){
    $msg .= "・playbookidが指定されていません.<br />";
    $error +=1;
}
if(!isset($_REQUEST["hid"])){
    $msg .= "・hostidが指定されていません.<br />";
    $error += 1;
}
if($error > 0){
    require_once("hosts_playbook.php");
    exit(1);
}

$db = new AnsibleWebDB();
$host = $db->getHost($_REQUEST["hid"]);
$playbook = $db->getPlaybook($_REQUEST["pid"]);

$cmd = "ansible-playbook -l ".$host->hostname . " " . $playbook->path . " --check";
$msg .= $cmd . "<br />";

$db->addHistory($host->id,$playbook->id);

?>