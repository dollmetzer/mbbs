<?php include PATH_APP . '/modules/core/views/web/_elements/head.php'; ?>

<p><a href="<?php $this->buildURL('bbs/board/reply/'.$content['mail']['id']); ?>" class="btn"><i class="fa fa-reply"></i> <?php $this->lang('link_reply_mail'); ?></a>

<table>
    <tr><td colspan="2"><hr /></td></tr>
    <tr style="border-top: 1px solid #dddddd;">
        <td><?php $this->lang('table_col_from'); ?>&nbsp;</td>
        <td>:&nbsp;<?php echo $content['mail']['from']; ?></td>
    </tr>
    <tr>
        <td><?php $this->lang('table_col_date'); ?>&nbsp;</td>
        <td>:&nbsp;<?php echo $this->toDatetimeShort($content['mail']['written'], false); ?></td>
    </tr>
    <tr>
        <td><?php $this->lang('table_col_subject'); ?>&nbsp;</td>
        <td>:&nbsp;<?php echo $content['mail']['subject']; ?></td>
    </tr>
    <tr><td colspan="2"><hr /></td></tr>
    <tr>
        <td colspan="2"><?php echo nl2br($content['mail']['message']); ?></td>
    </tr>
    <tr><td colspan="2"><hr /></td></tr>
</table>

<?php include PATH_APP . '/modules/core/views/web/_elements/foot.php'; ?>