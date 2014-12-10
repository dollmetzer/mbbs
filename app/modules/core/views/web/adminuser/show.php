<?php include PATH_APP.'/modules/core/views/web/_elements/head.php'; ?>

<table class="table table-striped">
    <tbody>
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
        <td><?php if($content['user']['active'] == 1) { 
                $this->lang('txt_active');
            } else {
                $this->lang('txt_inactive');
            } ?></td>
    </tr>
    <tr>
        <td><strong><?php $this->lang('table_col_created') ?></strong></td>
        <td><?php echo $this->toDate($content['user']['created']) ?></td>
    </tr>
    <tr>
        <td><strong><?php $this->lang('table_col_lastlogin') ?></strong></td>
        <td><?php echo $this->toDate($content['user']['lastlogin']) ?></td>
    </tr>
    <tr>
        <td><strong><?php $this->lang('table_col_groups') ?></strong></td>
        <td><?php 
            foreach($content['groups'] as $pos=>$group) {
                if(!empty($group['active'])) {
                    echo '<span title="'.$group['description'].'">'.$group['name']."</span><br />\n";
                }
            }
        ?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><a href="<?php $this->buildURL('core/adminuser/edit/'.$content['user']['id']); ?>" class="btn btn-default"><?php $this->lang('link_edit'); ?></a></td>
    </tr>
    <?php if($content['user']['lastlogin'] == '0000-00-00 00:00:00') { ?>
    <tr>
        <td>&nbsp;</td>
        <td><a href="<?php $this->buildURL('core/adminuser/delete/'.$content['user']['id']); ?>" class="btn btn-default"><?php $this->lang('link_delete'); ?></a></td>
    </tr>
    <?php } ?>
    </tbody>
</table>

<?php include PATH_APP.'/modules/core/views/web/_elements/foot.php'; ?>