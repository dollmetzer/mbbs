<?php include PATH_APP . '/modules/core/views/web/_elements/head.php'; ?>

<p><a href="<?php echo $this->buildURL('bbs/mail/in'); ?>" class="btn-small"><i class="fa fa-sign-in"></i> <?php $this->lang('link_inbox'); ?></a>
<a href="<?php echo $this->buildURL('bbs/mail/out'); ?>" class="btn-small"><i class="fa fa-sign-out"></i> <?php $this->lang('link_outbox'); ?></a>
</p><p>
<a href="<?php echo $this->buildURL('bbs/mail/new'); ?>" class="btn"><i class="fa fa-pencil"></i> <?php $this->lang('link_new_mail'); ?></a>
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