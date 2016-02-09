<?php
exec("/usr/bin/ansible all -i " . HOSTS_FILE . " -m setup --tree " . FACTS_DIR);
$msg = "Ansible Facts を更新しました.";
?>