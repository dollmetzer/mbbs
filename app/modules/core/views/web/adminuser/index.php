<?php include PATH_APP.'/modules/core/views/web/_elements/head.php'; ?>

<table class="table table-striped">
    <thead>
        <tr>
            <th><?php $this->lang('table_col_handle'); ?></th>
            <th><?php $this->lang('table_col_language'); ?></th>
            <th><?php $this->lang('table_col_created'); ?></th>
            <th><?php $this->lang('table_col_lastlogin'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($content['list'] as $entry) { ?>
        <tr onclick="location.href='<?php $this->buildURL('core/adminuser/show/'.$entry['id']); ?>';" style="cursor: pointer;">
            <td><?php if(empty($entry['active'])) { ?>
                <span class="glyphicon glyphicon-ban-circle"></span>
            <?php } else { ?>
                <span class="glyphicon glyphicon-ok-circle"></span>
            <?php }
                echo $entry['handle'] 
            ?>
            </td>
            <td><?php echo $entry['language'] ?></td>
            <td><?php echo $this->toDateTimeShort($entry['created']); ?></td>
            <td><?php echo $this->toDateTimeShort($entry['lastlogin']); ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php include PATH_APP.'/modules/core/views/web/_elements/foot.php'; ?>