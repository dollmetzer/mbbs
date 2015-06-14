<?php include PATH_APP . '/modules/core/views/web/_elements/head.php'; ?>

<?php include PATH_APP . '/modules/core/views/web/_elements/form.php'; ?>

<hr />
<h3><?php $this->lang('title_admin_usergroups'); ?></h3>
<p><?php $this->lang('txt_user_groups'); ?></p>
<?php 
foreach($content['groups'] as $pos=>$group) {
    if(!empty($group['active'])) {
        echo '<p>&nbsp;<a href="#" onclick="deletegroup('.$group['id'];
        echo ')" title="'.$this->lang('link_delete', false);
        echo '" class="btn-small"><i class="fa fa-trash"></i></a>&nbsp;'.$group['name'].'</p>';
    }
}
?>

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