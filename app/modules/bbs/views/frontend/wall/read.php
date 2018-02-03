<?php include PATH_APP . '/modules/core/views/frontend/_elements/head.php'; ?>

<article class="messagehead">
    <table>
        <tr>
            <td><strong><?php $this->lang('table_col_from'); ?></strong></td>
            <td>&nbsp;:&nbsp;<?php echo $content['mail']['from']; ?></td>
        </tr>
        <tr>
            <td><strong><?php $this->lang('table_col_date'); ?></strong></td>
            <td>&nbsp;:&nbsp;<?php echo $this->toDatetimeShort($content['mail']['written'], false); ?></td>
        </tr>
        <tr>
            <td><strong><?php $this->lang('table_col_subject'); ?></strong></td>
            <td>&nbsp;:&nbsp;<?php echo $content['mail']['subject']; ?></td>
        </tr>
    </table>
</article>

<article class="messagebody"><?php echo nl2br($content['mail']['message']); ?></article>

<?php if($content['picture'] === true) { ?>
<p><img src="<?php $this->buildURL('bbs/wall/img/'.$content['mail']['id']); ?>" style="width:100%;" /></p>
<?php } ?>

<br />
<p><a href="<?php $this->buildURL('bbs/wall'); ?>" class="btn"><i class="fa fa-chevron-left"></i> <?php $this->lang('link_wall'); ?></a></p>

<?php include PATH_APP . '/modules/core/views/frontend/_elements/foot.php'; ?>