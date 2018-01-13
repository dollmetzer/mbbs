<?php include PATH_APP . '/modules/core/views/frontend/_elements/head.php'; ?>
<p>
    <a href="<?php echo $this->buildURL('bbs/mail/in'); ?>" class="btn-small"><i class="fa fa-sign-in"></i> <?php $this->lang('link_inbox'); ?></a>
    <a href="<?php echo $this->buildURL('bbs/mail/out'); ?>" class="btn-small"><i class="fa fa-sign-out"></i> <?php $this->lang('link_outbox'); ?></a>
</p>

<?php if(strtolower($content['mail']['from']) != strtolower($content['username']) ) { ?>
<p style="margin-top:10px;"><a href="<?php $this->buildURL('bbs/mail/reply/'.$content['mail']['id']); ?>" class="btn"><i class="fa fa-reply"></i> <?php $this->lang('link_reply_mail'); ?></a>
<a href="<?php $this->buildURL('bbs/mail/delete/'.$content['mail']['id']); ?>" class="btn"><i class="fa fa-eraser"></i> <?php $this->lang('link_delete_mail'); ?></a>
</p>
<?php } ?> 

<table>
    <tr><td colspan="2"><hr /></td></tr>
    <tr>
        <td><strong><?php $this->lang('table_col_from'); ?>&nbsp;</strong></td>
        <td><?php echo $content['mail']['from']; ?></td>
    </tr>
    <tr>
        <td><strong><?php $this->lang('table_col_to'); ?>&nbsp;</strong></td>
        <td><?php echo $content['mail']['to']; ?></td>
    </tr>
    <tr>
        <td><strong><?php $this->lang('table_col_date'); ?>&nbsp;</strong></td>
        <td><?php echo $this->toDatetimeShort($content['mail']['written'], false); ?></td>
    </tr>
    <tr>
        <td><strong><?php $this->lang('table_col_subject'); ?>&nbsp;</strong></td>
        <td><?php echo $content['mail']['subject']; ?></td>
    </tr>
    <tr><td colspan="2"><hr /></td></tr>
    <tr>
        <td colspan="2"><?php if(empty($content['mail']['message'])) {
            $this->lang('msg_message_empty');
        } else { 
            echo nl2br($content['mail']['message']); 
        } ?></td>
    </tr>
    <tr><td colspan="2"><hr /></td></tr>
</table>

<?php if($content['picture'] === true) { ?>
<p><img src="<?php $this->buildURL('bbs/mail/img/'.$content['mail']['id']); ?>" style="width:100%;" /></p>
<?php } ?>

<?php include PATH_APP . '/modules/core/views/frontend/_elements/foot.php'; ?>