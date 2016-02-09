<?php
require_once("include/config.php");

$page_id = 4;
$page_title = "Ansible Facts";
if($_REQUEST["cmd"]=="update"){
    require_once("include/update_facts.php");
}
?>

<?php require_once("header.php");?>
<?php $hosts = getFACTS(FACTS_DIR); ?>
<table id="hosts" class="table table-condensed">
    <thead><tr><th>#</th><th>Hostname</th><th>OS</th><th>IPAddress</th></tr></thead>
    <tbody>
<?php for($i=0;$i<count($hosts);$i++) : ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $hosts[$i]['ansible_facts']['ansible_nodename']; ?></td>
            <td><?php echo $hosts[$i]['ansible_facts']['ansible_distribution'] . ":" . $hosts[$i]['ansible_facts']['ansible_distribution_version']; ?></td>
            <td><?php echo join("<br />" , $hosts[$i]['ansible_facts']['ansible_all_ipv4_addresses']) ;?></td>
        </tr>
<?php endfor;?>
    </tbody>
</table>
<script>
$(document).ready(function(){
   $('table#hosts').DataTable();
});
</script>
<a class="btn btn-default" type="button" href="facts.php?cmd=update">更新</a>

<?php require_once("footer.php");?>