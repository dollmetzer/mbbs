<?php include PATH_APP.'/modules/core/views/web/_elements/head.php'; ?>

<table class="table table-striped">
    <tbody>
    <tr>
        <td><strong><?php $this->lang('table_col_name') ?></strong></td>
        <td><?php echo $content['group']['name'] ?></td>
    </tr>
    <tr>
        <td><strong><?php $this->lang('table_col_active') ?></strong></td>
        <td><?php if($content['group']['active'] == 1) { 
                $this->lang('txt_active');
            } else {
                $this->lang('txt_inactive');
            } ?></td>
    </tr>
    <tr>
        <td><strong><?php $this->lang('table_col_description') ?></strong></td>
        <td><?php echo $content['group']['description'] ?></td>
    </tr>
        <tr>
        <td>&nbsp;</td>
        <td><a href="<?php $this->buildURL('core/admingroup/edit/'.$content['group']['id']); ?>" class="btn btn-default"><?php $this->lang('link_edit'); ?></a></td>
    </tr>
    </tbody>
</table>

<?php include PATH_APP.'/modules/core/views/web/_elements/foot.php'; ?>