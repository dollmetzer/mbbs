<?php include PATH_APP . '/modules/core/views/web/_elements/head.php'; ?>

<table>
    <tr><td colspan="2"><hr /></td></tr>
    <tr style="border-top: 1px solid #dddddd;">
        <td><strong><?php $this->lang('table_col_from'); ?>&nbsp;</strong></td>
        <td><?php echo $content['mail']['from']; ?></td>
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

<p><a href="<?php $this->buildURL('bbs/board/reply/'.$content['mail']['id']); ?>" class="btn"><i class="fa fa-reply"></i> <?php $this->lang('link_reply_mail'); ?></a>

<?php include PATH_APP . '/modules/core/views/web/_elements/foot.php'; ?>