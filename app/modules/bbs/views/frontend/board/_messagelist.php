<?php if(!empty($content['mails'])) {
    include PATH_APP . '/modules/core/views/frontend/_elements/pagination.php';
    ?>
    <table class="maillist striped">
        <?php foreach($content['mails'] as $mail) {?>
            <tr onclick="jumpto(<?php echo $mail['id']; ?>);" class="entry">
                <td><?php
                    $this->lang('table_col_from');
                    echo ' '.$mail['from'].' ';
                    $this->toDatetimeShort($mail['written']);
                    if(!empty($mail['picture'])) {
                        echo '&nbsp;<i class="fa fa-photo"></i>';
                    }
                    echo '<br /><strong>';
                    echo $mail['subject']; ?></strong></td>
            </tr>
        <?php } ?>
    </table>
    <?php
    include PATH_APP . '/modules/core/views/frontend/_elements/pagination.php';
} ?>
<script>
    function jumpto(id) {
        url = '<?php $this->buildURL('bbs/board/read/') ?>' + id;
        location.href = url;
    }
</script>

