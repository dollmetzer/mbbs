<?php include PATH_APP . '/modules/core/views/web/_elements/head.php'; ?>

<p><a href="<?php $this->buildURL('bbs/mail/in'); ?>" class="btn"><i class="fa fa-sign-in"></i> <?php $this->lang('link_inbox'); ?></a>
<a href="<?php $this->buildURL('bbs/mail/out'); ?>" class="btn"><i class="fa fa-sign-out"></i> <?php $this->lang('link_outbox'); ?></a>
</p>

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
        <td colspan="2"><?php echo nl2br($content['mail']['message']); ?></td>
    </tr>
    <tr><td colspan="2"><hr /></td></tr>
</table>

<p style="margin-top:10px;"><a href="<?php $this->buildURL('bbs/mail/reply/'.$content['mail']['id']); ?>" class="btn"><i class="fa fa-reply"></i> <?php $this->lang('link_reply_mail'); ?></a>
<a href="<?php $this->buildURL('bbs/mail/delete/'.$content['mail']['id']); ?>" class="btn"><i class="fa fa-eraser"></i> <?php $this->lang('link_delete_mail'); ?></a>
</p>

<?php include PATH_APP . '/modules/core/views/web/_elements/foot.php'; ?>