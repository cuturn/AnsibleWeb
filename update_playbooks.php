<?php
require_once("include/config.php");

$common = getYAML(ANSIBLE_DIR . "/common-playbooks");
$platform = getYAML(ANSIBLE_DIR . "/platform-playbooks");
$system = getYAML(ANSIBLE_DIR . "/system-playbooks");

$db = new AnsibleWebDB();
$db->addPlaybooks($common);
$db->addPlaybooks($platform);
$db->addPlaybooks($system);
?>