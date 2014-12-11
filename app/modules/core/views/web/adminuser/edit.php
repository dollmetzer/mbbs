<?php include PATH_APP . '/modules/core/views/web/_elements/head.php'; ?>

<?php include PATH_APP . '/modules/core/views/web/_elements/form.php'; ?>

<hr />
<h3>Gruppen</h3>
<select id="addgroup" onchange="addgroup();">
    <option value=""><?php $this->lang('form_option_add'); ?></option>
<?php 
foreach($content['allgroups'] as $pos=>$group) {
    if(!empty($group['active'])) {
        echo '<option value="'.$group['id'].'">'.$group['name']."</option>\n";
    }
}

?>
</select>
<br />
<?php 
foreach($content['groups'] as $pos=>$group) {
    if(!empty($group['active'])) {
        echo '<p>&nbsp;<a href="#" onclick="deletegroup('.$group['id'];
        echo ')" title="'.$this->lang('link_delete', false);
        echo '" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-trash"></i></a>&nbsp;'.$group['name'].'</p>';
    }
}
?>
<br />&nbsp;
<script>
function addgroup() {
    var gid = document.getElementById('addgroup').value;
    if(gid) {
        var url = '<?php $this->buildURL('adminuser/addgroup/'.$content['user']['id'].'/') ?>' + gid;
        window.location.href = url;
    }
}
function deletegroup(gid) {
    if(gid) {
        var url = '<?php $this->buildURL('adminuser/deletegroup/'.$content['user']['id'].'/') ?>' + gid;
        window.location.href = url;
    }
}
</script>

<?php include PATH_APP . '/modules/core/views/web/_elements/foot.php'; ?>