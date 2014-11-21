<?php include PATH_APP . '/modules/core/views/web/_elements/head.php'; ?>

<p><?php echo sprintf($this->lang('txt_hosts_intro', false), $this->app->config['systemname']) ; ?></p>

<form action="<?php $this->buildURL('bbs/operation/addhost'); ?>" method="post">
<div class="panel panel-default">
<table class="table striped">
    <thead>
        <tr>
            <th><?php $this->lang('table_col_name'); ?></th>
            <th><?php $this->lang('table_col_lastexport'); ?></th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($content['list'] as $host) { 
            if($host['id'] == 1) continue; ?>
        <tr>
            <td><strong><?php echo $host['name'] ?></strong></td>
            <td><?php 
                if($host['lastexport'] == '0000-00-00 00:00:00') {
                    echo $this->lang('txt_never_exported');
                } else {
                    echo $this->toDateTimeShort($host['lastexport']);
                } ?></td>
            <td>
                <a href="javascript:deletehost(<?php echo $host['id'] ?>);" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-ban-circle"></span> <?php $this->lang('btn_unlink'); ?></a>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="3"><input type="text" name="newhost" value="" maxlength="16" />&nbsp;<?php $this->lang('txt_add_host'); ?></td>
        </tr>
    </tbody>
</table>
</div>
</form>
    
<script type="text/javascript">
function deletehost(id) {
    if(id < 2) return;
    if(confirm("<?php $this->lang('msg_delete_confirm'); ?>")) {
        url = '<?php $this->buildURL('bbs/operation/deletehost'); ?>/' + id;
        location.href= url;
    }
}
</script>

<?php include PATH_APP . '/modules/core/views/web/_elements/foot.php'; ?>