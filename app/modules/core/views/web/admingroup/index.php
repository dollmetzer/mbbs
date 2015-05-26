<?php include PATH_APP.'/modules/core/views/web/_elements/head.php'; ?>

<p><a href="<?php $this->buildURL('core/admingroup/add'); ?>" class="btn"><i class="fa fa-plus"></i> <?php $this->lang('link_group_add'); ?></a></p>

<table class="maillist striped">
    <thead>
        <tr>
            <th><?php $this->lang('table_col_name'); ?></th>
            <th><?php $this->lang('table_col_description'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($content['list'] as $entry) { ?>
        <tr onclick="location.href='<?php $this->buildURL('core/admingroup/show/'.$entry['id']); ?>';" style="cursor: pointer;">
            <td><?php if(empty($entry['active'])) { ?>
                <i class="fa fa-ban"></i>
            <?php } else { ?>
                <i class="fa fa-check"></i>
            <?php }
                echo $entry['name'] 
            ?>
            </td>
            <td><?php echo $entry['description'] ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php include PATH_APP.'/modules/core/views/web/_elements/foot.php'; ?>