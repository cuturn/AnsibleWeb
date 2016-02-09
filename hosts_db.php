<?php
require_once("include/config.php");

$page_id = 5;
$page_title = "Ansible Hosts(DB)";
$db = new AnsibleWebDB();
$hosts = $db->getHosts();
?>

<?php require_once("header.php");?>
<table id="hosts" class="table table-condensed">
    <thead><tr><th>#ID</th><th>Hostname</th><th>OS</th><th>IPAddress</th><th>Variables</th></tr></thead>
    <tbody>
<?php for($i=0;$i<count($hosts);$i++) : ?>
        <tr>
            <td><?php echo $hosts[$i]['id']; ?></td>
            <td><?php echo $hosts[$i]['hostname']; ?></td>
            <td><?php echo $hosts[$i]['ipaddress']; ?></td>
            <td><?php echo $hosts[$i]['Variables']; ?></td>
        </tr>
<?php endfor;?>
    </tbody>
</table>

<script>
$(document).ready(function(){
   $('table#hosts').DataTable();
});
</script>

<?php require_once("footer.php");?>