<?php include PATH_APP . '/modules/core/views/web/_elements/head.php'; ?>

<table class="maillist striped">
    <thead>
        <tr>
            <td><strong><?php $this->lang('table_handle'); ?></strong></td>
            <td><strong><?php $this->lang('table_lastlogin'); ?></strong></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach($content['users'] as $user) { ?>
        <tr class="entry" id="<?php echo $user['handle']; ?>">
            <td><?php echo $user['handle'] ?></td>
            <td><?php echo $this->toDatetime($user['lastlogin']); ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
    $(".entry").click(function() {
        var id = $(this).attr('id');
        url = '<?php $this->buildURL('/bbs/mail/new'); ?>/'+id;
        location.href=url;
    });
</script>

<?php include PATH_APP . '/modules/core/views/web/_elements/foot.php'; ?>