<?php
require_once("include/config.php");

$page_id = 1;
$page_title = "Ansible Hosts";
$hostsobj = new AnsibleWebHosts(HOSTS_FILE);
?>

<?php require_once("header.php");?>
<?php $hosts = $hostsobj->getHosts(); ?>
<table class="table table-condensed" id="table_hosts">
    <thead><tr><th>#</th><th>Hostname</th><th>IPAddress</th><th>groups</th><th>fact.hostname</th><th>fact.OS</th></tr></thead>
    <tbody>
<?php for($i=0;$i<count($hosts);$i++) : $hosts[$i]->setFact(FACTS_DIR);?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $hosts[$i]->hostname; ?></td>
            <td><?php echo $hosts[$i]->ipaddress ;?></td>
            <td><?php for($j=0;$j<count($hosts[$i]->groups);$j++):?><span onclick="searchTable('<?php echo $hosts[$i]->groups[$j];?>')" style="margin:.2em .2em" class="label <?php if($hosts[$i]->groups[$j]==="all"){echo "label-default";}else{echo "label-primary";}?>"><?php echo $hosts[$i]->groups[$j];?></span><?php endfor;?></td>
            <td><?php echo $hosts[$i]->fact["ansible_facts"]["ansible_nodename"];?></td>
            <td><?php echo $hosts[$i]->fact['ansible_facts']['ansible_distribution'] . ":" . $hosts[$i]->fact['ansible_facts']['ansible_distribution_version'];?></td>
        </tr>
<?php endfor; ?>
    </tbody>
</table>
<script>
$(document).ready(function(){
   $('table#table_hosts').DataTable();
});
function searchTable(query){
    var tbl = $('table#table_hosts').DataTable();
    tbl.search(query);
    tbl.draw();
}
</script>
<?php require_once("footer.php");?>