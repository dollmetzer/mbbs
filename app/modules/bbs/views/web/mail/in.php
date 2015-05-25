<?php include PATH_APP . '/modules/core/views/web/_elements/head.php'; ?>

<p><a href="<?php echo $this->buildURL('bbs/mail/in'); ?>" class="btn"><i class="fa fa-sign-in"></i> <?php $this->lang('link_inbox'); ?></a>&nbsp;
<a href="<?php echo $this->buildURL('bbs/mail/out'); ?>" class="btn"><i class="fa fa-sign-out"></i> <?php $this->lang('link_outbox'); ?></a>&nbsp;
<a href="<?php echo $this->buildURL('bbs/mail/new'); ?>" class="btn"><i class="fa fa-pencil"></i> <?php $this->lang('link_new_mail'); ?></a>
</p>

<?php if(empty($content['mails'])) { ?>
<p><strong><?php $this->lang('msg_no_mails'); ?></strong></p>
<?php } else { ?>

<table class="maillist striped">
<?php foreach($content['mails'] as $mail) {?>
    <tr onclick="jumpto(<?php echo $mail['id']; ?>);">
        <td><?php if($mail['read'] == '0000-00-00 00:00:00') {
            echo '<strong><span class="glyphicon glyphicon-asterisk" title="';
            echo $this->lang('txt_unread');
            echo '"></span></strong>&nbsp;'; } ?><?php $this->lang('table_col_from'); ?> <?php echo $mail['from']; ?>
            <?php echo $this->toDatetimeShort($mail['written'], false); ?><br />
            <strong><?php echo $mail['subject']; ?></strong></td>
    </tr>
<?php } ?>
</table>
<?php } ?>

<script type="text/javascript">
    function jumpto(id) {
        url = '<?php $this->buildURL('bbs/mail/read/') ?>' + id;
        location.href = url;
    }
</script>

<?php include PATH_APP . '/modules/core/views/web/_elements/foot.php'; ?>