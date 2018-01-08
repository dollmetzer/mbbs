<?php
$content['nav_main'] = 'adminuser';
include PATH_APP.'modules/core/views/backend/_elements/head.php'; ?>


<table class="table table-striped">
    <colgroup>
        <col style="width:25%;">
        <col style="width:75%;">
    </colgroup>
    <tr>
        <td><strong><?php $this->lang('table_col_handle'); ?></strong></td>
        <td><?php echo $content['user']['handle']; ?></td>
    </tr>
    <tr>
        <td><strong><?php $this->lang('table_col_email'); ?></strong></td>
        <td><?php echo $content['user']['email']; ?></td>
    </tr>
    <tr>
        <td><strong><?php $this->lang('table_col_id'); ?></strong></td>
        <td><?php echo $content['user']['id']; ?></td>
    </tr>
    <tr>
        <td><strong><?php $this->lang('table_col_language'); ?></strong></td>
        <td><?php echo $this->lang('language_'.$content['user']['language']).' ('.$content['user']['language'].')'; ?></td>
    </tr>
    <tr>
        <td><strong><?php $this->lang('table_col_groups'); ?></strong></td>
        <td><?php
            if(empty($content['groups'])) {
                echo "---";
            } else {
                foreach($content['groups'] as $group) {
                    echo $group['name'].' ('.$group['description'].")<br />";
                }
            }
            ?>
    </tr>
    <tr>
        <td><strong><?php $this->lang('table_col_created'); ?></strong></td>
        <td><?php $this->toDatetime($content['user']['created']); ?></td>
    </tr>
    <tr>
        <td><strong><?php $this->lang('table_col_confirmed'); ?></strong></td>
        <td><?php $this->toDatetime($content['user']['confirmed']); ?></td>
    </tr>
    <tr>
        <td><strong><?php $this->lang('table_col_lastlogin'); ?></strong></td>
        <td><?php $this->toDatetime($content['user']['lastlogin']); ?></td>
    </tr>
    <tr>
        <td><strong><?php $this->lang('table_col_active_visible'); ?></strong></td>
        <td><?php if(!empty($content['user']['active'])) {
                $this->lang('txt_core_yes');
            } else {
                $this->lang('txt_core_no');
            } ?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <a href="<?php $this->buildUrl('users/adminuser/edit/'.$content['user']['id']); ?>" class="btn btn-default" ><?php $this->lang('link_core_edit'); ?></a>
            <?php if($content['user']['id'] != $this->session->user_id) { ?>
            <a data-toggle="modal" data-target="#confirm-delete" data-href="<?php $this->buildUrl('users/adminuser/delete/'.$content['user']['id']); ?>" class="btn btn-danger" ><?php $this->lang('link_core_delete'); ?></a>
            <?php } ?>
        </td>
    </tr>
</table>

<?php include PATH_APP.'modules/core/views/backend/_elements/foot.php'; ?>
