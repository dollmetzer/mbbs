<?php include PATH_APP.'/modules/core/views/web/_elements/head.php'; ?>

<table class="table table-striped">
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
                <span class="glyphicon glyphicon-ban-circle"></span>
            <?php } else { ?>
                <span class="glyphicon glyphicon-ok-circle"></span>
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