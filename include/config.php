<?php
define("ANSIBLE_DIR","/etc/ansible");
define("HOSTS_FILE","/etc/ansible/hosts");
define("FACTS_DIR","/var/ansible_facts");

require_once(dirname(__FILE__) . "/../include/functions.php");
require_once(dirname(__FILE__) . "/../class/AnsibleHost.class.php");
require_once(dirname(__FILE__) . "/../class/AnsibleWebDB.class.php");
require_once(dirname(__FILE__) . "/../class/AnsibleWebHosts.class.php");
?>