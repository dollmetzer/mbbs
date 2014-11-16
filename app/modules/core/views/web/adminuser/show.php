<?php include PATH_APP.'/modules/core/views/web/_elements/head.php'; ?>


<table>
    <tr>
        <td><strong><?php $this->lang('table_col_handle') ?></strong></td>
        <td><?php echo $content['user']['handle'] ?></td>
    </tr>
    <tr>
        <td><strong><?php $this->lang('table_col_language') ?></strong></td>
        <td><?php echo $content['user']['language'] ?></td>
    </tr>
    <tr>
        <td><strong><?php $this->lang('table_col_active') ?></strong></td>
        <td><?php echo $content['user']['active'] ?></td>
    </tr>
    <tr>
        <td><strong><?php $this->lang('table_col_created') ?></strong></td>
        <td><?php echo $content['user']['created'] ?></td>
    </tr>
    <tr>
        <td><strong><?php $this->lang('table_col_lastlogin') ?></strong></td>
        <td><?php echo $content['user']['lastlogin'] ?></td>
    </tr>
        <tr>
        <td><strong><?php $this->lang('table_col_groups') ?></strong></td>
        <td></td>
    </tr>
        <tr>
        <td>&nbsp;</td>
        <td><a href="<?php $this->buildURL('core/adminuser/edit/'.$content['user']['id']); ?>" class="btn btn-default"><?php $this->lang('link_edit'); ?></a></td>
    </tr>
</table>

<?php include PATH_APP.'/modules/core/views/web/_elements/foot.php'; ?>