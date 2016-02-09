<?php
require_once("include/config.php");

$page_id = 2;
$page_title = "Ansible Playbooks";
require_once("header.php");
?>

<?php
$common = getYAML(ANSIBLE_DIR . "/common-playbooks");
$platform = getYAML(ANSIBLE_DIR . "/platform-playbooks");
$system = getYAML(ANSIBLE_DIR . "/system-playbooks");
$playbooks = array_merge($common,$platform,$system);
?>
<table id="playbooks" class="table table-condensed">
    <thead><tr><th>#</th><th>Name</th><th>Dir</th><th>Roles</th></tr></thead>
    <tbody>
<?php for($i=0;$i<count($playbooks);$i++) : ?>
        <tr>
            <td><?php echo $i;?></td>
            <td><?php echo basename($playbooks[$i]); ?></td>
            <td><?php echo dirname($playbooks[$i]); ?></td>
            <td>
                <?php foreach(getPlaybook($playbooks[$i])[0]["roles"] as $role): ?>
                <?php if(is_array($role)):?>
                <span class="label label-default" onclick="searchTable('<?php echo basename($role["role"]);?>')" title="<?php echo realpath(dirname($playbooks[$i])."/".$role["role"]);?>"><?php echo basename($role["role"]);?></span>
                <?php else: ?>
                <span class="label label-default" onclick="searchTable('<?php echo basename($role);?>')" title="<?php echo realpath(dirname($playbooks[$i])."/".$role);?>"><?php echo basename($role);?></span>
                <?php endif;?>
                <?php endforeach;?>
            </td>
         </tr>
<?php endfor;?>
    </tbody>
</table>
<script>
$(document).ready(function(){
   $('table#playbooks').DataTable({paging:false});
});
function searchTable(query){
    var tbl = $('table#playbooks').DataTable();
    tbl.search(query);
    tbl.draw();
}
</script>
<?php require_once("footer.php");?>