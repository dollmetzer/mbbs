<?php include PATH_APP.'/modules/core/views/web/_elements/head.php'; ?>

<p><a href="<?php $this->buildURL('core/adminuser/add'); ?>" class="btn"><i class="fa fa-user-plus"></i> <?php $this->lang('link_user_add'); ?></a></p>

<?php include PATH_APP . '/modules/core/views/web/_elements/pagination.php'; ?>

<table class="maillist striped">
    <thead>
        <tr>
            <th><?php $this->lang('table_col_handle'); ?></th>
            <th><?php $this->lang('table_col_lastlogin'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($content['list'] as $entry) { ?>
        <tr onclick="location.href='<?php $this->buildURL('core/adminuser/show/'.$entry['id']); ?>';" style="cursor: pointer;">
            <td><?php if(empty($entry['active'])) { ?>
                <i class="fa fa-ban"></i>
            <?php } else { ?>
                <i class="fa fa-check"></i>
            <?php }  echo $entry['handle'] ?></td>
            <td><?php echo $this->toDate($entry['lastlogin']); ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php include PATH_APP . '/modules/core/views/web/_elements/pagination.php'; ?>

<?php include PATH_APP.'/modules/core/views/web/_elements/foot.php'; ?>