<?php
$content['nav_main'] = 'admingroup';
include(PATH_APP . 'modules/core/views/backend/_elements/head.php');
?>

    <table class="table table-striped">
        <colgroup>
            <col style="width:25%;">
            <col style="width:75%;">
        </colgroup>
        <tr>
            <td><strong><?php $this->lang('table_col_name'); ?></strong></td>
            <td><?php echo $content['group']['name']; ?></td>
        </tr>
        <tr>
            <td><strong><?php $this->lang('table_col_description'); ?></strong></td>
            <td><?php echo $content['group']['description']; ?></td>
        </tr>
        <tr>
            <td><strong><?php $this->lang('table_col_id'); ?></strong></td>
            <td><?php echo $content['group']['id']; ?></td>
        </tr>
        <tr>
            <td><strong><?php $this->lang('table_col_active_visible'); ?></strong></td>
            <td><?php if(!empty($content['group']['active'])) {
                    $this->lang('txt_core_yes');
                } else {
                    $this->lang('txt_core_no');
                } ?></td>
        </tr>
        <tr>
            <td><strong><?php $this->lang('table_col_protected'); ?></strong></td>
            <td><?php if(!empty($content['group']['protected'])) {
                    $this->lang('txt_core_yes');
                } else {
                    $this->lang('txt_core_no');
                } ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><?php if($content['group']['protected'] != 1) {
                    echo '<a href="';
                    $this->buildUrl('users/admingroup/edit/'.$content['group']['id']);
                    echo '" class="btn btn-default">';
                    $this->lang('link_core_edit');
                    echo '</a>&nbsp;<a data-toggle="modal" data-target="#confirm-delete" data-href="';
                    $this->buildUrl('users/admingroup/delete/'.$content['group']['id']);
                    echo '" class="btn btn-danger">';
                    $this->lang('link_core_delete');
                    echo '</a>';
                } else {
                    echo '<button class="btn btn-default disabled">';
                    $this->lang('link_core_edit');
                    echo '</button>&nbsp;<button class="btn btn-danger disabled">';
                    $this->lang('link_core_delete');
                    echo '</button>';
                } ?></td>
        </tr>
    </table>

<?php include(PATH_APP . 'modules/core/views/backend/_elements/foot.php'); ?>