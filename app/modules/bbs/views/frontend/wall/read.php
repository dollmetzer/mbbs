<?php include PATH_APP . '/modules/core/views/frontend/_elements/head.php'; ?>

<table>
    <tr><td colspan="2"><hr /></td></tr>
    <tr>
        <td><?php $this->lang('table_col_from'); ?>&nbsp;:&nbsp;</td>
        <td><?php echo $content['mail']['from']; ?></td>
    </tr>
    <tr>
        <td><?php $this->lang('table_col_date'); ?>&nbsp;:&nbsp;</td>
        <td><?php echo $this->toDatetimeShort($content['mail']['written'], false); ?></td>
    </tr>
    <tr>
        <td><?php $this->lang('table_col_subject'); ?>&nbsp;:&nbsp;</td>
        <td><?php echo $content['mail']['subject']; ?></td>
    </tr>
    <tr><td colspan="2"><hr /></td></tr>
    <tr>
        <td colspan="2"><?php echo nl2br($content['mail']['message']); ?></td>
    </tr>
    <tr><td colspan="2"><hr /></td></tr>
</table>

<?php if($content['picture'] === true) { ?>
<p><img src="<?php $this->buildURL('bbs/wall/img/'.$content['mail']['id']); ?>" style="width:100%;" /></p>
<?php } ?>

<br />
<p><a href="<?php $this->buildURL('bbs/wall'); ?>" class="btn"><i class="fa fa-chevron-left"></i> <?php $this->lang('link_wall'); ?></a></p>

<?php include PATH_APP . '/modules/core/views/frontend/_elements/foot.php'; ?>