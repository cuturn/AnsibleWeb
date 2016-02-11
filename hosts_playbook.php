<?php
require_once("include/config.php");

$page_id = 7;
$page_title = "Ansible HostsPlaybook";
$db = new AnsibleWebDB();
$hosts = $db->getHosts();
$playbooks = $db->getPlaybooks();
$history = $db->getPlayHistory();
?>

<?php require_once("header.php");?>
<table id="phrel" class="table table-condensed">
    <thead><tr><th>Playbook\Hosts</th><?php for($i=0;$i<count($hosts);$i++):?><th><?php echo $hosts[$i]["id"] . "." . $hosts[$i]["hostname"] ;?></th><?php endfor;?></thead>
    <tbody>
    <?php for($j=0;$j<count($playbooks);$j++) : ?>
    <tr>
        <td><?php echo $playbooks[$j]["name"]; ?></td>
        <?php for($i=0;$i<count($hosts);$i++):?>
        <td>
            <a href="run_playbook.php?hid=<?php echo $hosts[$i]["id"];?>&pid=<?php echo $playbooks[$j]["id"];?>">>></a>
            <?php $hit=false;?>
            <?php for($k=0;$k<count($history);$k++):?>
                <?php if($history[$k]["hostid"]===$hosts[$i]["id"] && $history[$k]["playbookid"]===$playbooks[$j]["id"]):?>
                    <?php $hit=true;?>
                    <?php echo $history[$k]["date"];?><br /><span style="color:green"><?php echo $history[$k]["ok"];?></span>&nbsp;<span style="color:orange"><?php echo $history[$k]["changed"];?></span>&nbsp;<span style="color:red"><?php echo ($history[$k]["unreachable"]+$history[$k]["failed"]);?></span></td><?php break;?>
                <?php endif;?>
            <?php endfor;?>
            <?php if(!$hit):?>
                2015/01/24<br /><span style="color:green">4</span>&nbsp;<span style="color:orange">2</span>&nbsp;<span style="color:red">0</span>
            <?php endif;?>
        </td>
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