<?php
require_once("include/config.php");

$page_id = 5;
$page_title = "Ansible HostsPlaybook";
$db = new AnsibleWebDB();
$hosts = $db->getHosts();
$playbooks = $db->getPlaybooks();
?>

<?php require_once("header.php");?>
<table id="phrel" class="table table-condensed">
    <thead><tr><th>Playbook\Hosts</th><?php for($i=0;$i<count($hosts);$i++):?><th><?php echo $hosts[$i]["id"] . "." . $hosts[$i]["hostname"] ;?></th><?php endfor;?></thead>
    <tbody>
    <?php for($j=0;$j<count($playbooks);$j++) : ?>
    <tr>
        <td><?php echo $playbooks[$j]["name"]; ?></td>
        <?php for($i=0;$i<count($hosts);$i++):?>
        <td>2015/01/24<br /><span style="color:green">4</span>&nbsp;<span style="color:orange">2</span>&nbsp;<span style="color:red">0</span></td>
        <?php endfor;?></tr>
    <?php endfor;?>
    </tbody>
</table>

<script>
$(document).ready(function(){
   $('table#phrel').DataTable({paging:false});
});
</script>

<?php require_once("footer.php");?>