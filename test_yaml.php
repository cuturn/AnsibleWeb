<?php
require_once("include/config.php");

$yaml = getPlaybook("/etc/ansible/common-playbooks/CentOS6/setup_CentOS6.yml");
var_dump($yaml);



?>