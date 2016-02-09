<?php
require_once(dirname(__FILE__) . "/include/config.php");

$hostsobj = new AnsibleWebHosts(HOSTS_FILE);
$hosts = $hostsobj->getHosts();

$db = new AnsibleWebDB();
$db->addHosts($hosts);
$db = null;

?>
