<?php include PATH_APP . '/modules/core/views/frontend/_elements/head.php';

// B r e a d c r u m b
echo '<p class="breadcrumb">';
echo '<i class="fa fa-book fa-fw"></i>&nbsp;<a href="';
$this->buildURL('bbs/board/list/0');
echo '">';
$this->lang('link_mainboard');
echo '</a>';
foreach($content['path'] as $step) {
    echo '&nbsp;/&nbsp;<a href="'.$this->buildURL('bbs/board/list/'.$step['id'], false).'">';
    echo $step['name'];
    echo "</a>";
}
echo "</p>\n";

?>

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
<p><img src="<?php $this->buildURL('bbs/board/img/'.$content['mail']['id']); ?>" style="width:100%;" /></p>
<?php } ?>

<p><a href="<?php $this->buildURL('bbs/board/reply/'.$content['mail']['id']); ?>" class="btn"><i class="fa fa-reply"></i> <?php $this->lang('link_reply_mail'); ?></a>

<?php include PATH_APP . '/modules/core/views/frontend/_elements/foot.php'; ?>