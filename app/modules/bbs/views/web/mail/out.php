<?php include PATH_APP . '/modules/core/views/web/_elements/head.php'; ?>

<p><a href="<?php echo $this->buildURL('bbs/mail/in'); ?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-log-in"></span> <?php $this->lang('link_inbox'); ?></a>&nbsp;
<a href="<?php echo $this->buildURL('bbs/mail/out'); ?>" class="btn btn-default btn-xs disabled"><span class="glyphicon glyphicon-log-out"></span> <?php $this->lang('link_outbox'); ?></a>
<a href="<?php echo $this->buildURL('bbs/mail/new'); ?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span> <?php $this->lang('link_new_mail'); ?></a>
</p>

<?php if(empty($content['mails'])) { ?>
<p><strong><?php $this->lang('msg_no_mails'); ?></strong></p>
<?php } else { ?>

<table class="maillist striped">
<?php foreach($content['mails'] as $mail) {?>
    <tr onclick="jumpto(<?php echo $mail['id']; ?>);">
        <td><?php $this->lang('table_col_to'); ?> <?php echo $mail['to']; ?>
            <?php echo $this->toDatetimeShort($mail['written'], false); ?><br />
            <strong><?php echo $mail['subject']; ?></strong></td>
    </tr>
<?php } ?>    
</table>

<script type="text/javascript">
    function jumpto(id) {
        url = '<?php $this->buildURL('bbs/mail/read/') ?>' + id;
        location.href = url;
    }
</script>
<?php } ?>

<?php include PATH_APP . '/modules/core/views/web/_elements/foot.php'; ?>