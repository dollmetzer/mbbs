<?php include PATH_APP . '/modules/core/views/web/_elements/head.php'; 

if(!empty($content['board']['description'])) {
    echo '  <p>'.$content['board']['description']."</p>";
}
?>
<p>
    <a href="<?php $this->buildURL('bbs/board/list/0'); ?>">main</a>
    <?php 
    foreach($content['path'] as $step) {
        echo '&nbsp;/&nbsp;<a href="'.$this->buildURL('bbs/board/list/'.$step['id'], false).'">';
        echo $step['name'];
        echo "</a>";
    }
    ?>
</p>

<?php if(!empty($content['board']['content'])) { ?>
<p><a href="<?php echo $this->buildURL('bbs/board/new/'.$content['id']); ?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-log-in"></span> <?php $this->lang('btn_new_article'); ?></a></p>
<?php } ?>

<?php if(!empty($content['themes'])) { ?>
<table class="maillist striped">
<?php foreach($content['themes'] as $theme) { ?>
    <tr onclick="showboard(<?php echo $theme['id']; ?>);">
        <td>
            <?php if(in_array('admin', $this->app->session->groups)) { ?>
            <a href="<?php $this->buildURL('bbs/boardadmin/edit/'.$theme['id']); ?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span></a> 
            <a href="<?php $this->buildURL('bbs/boardadmin/delete/'.$theme['id']); ?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-trash"></span></a> 
            <?php } ?>
            <strong><?php echo $theme['name']; ?></strong><br /><?php echo $theme['description']; ?></a>
        </td>
    </tr>
    <?php } ?>
</table>
<?php 
if(in_array('admin', $this->app->session->groups)) {
    echo '<br /><p><a href="';
    echo $this->buildURL('bbs/boardadmin/add/'.$content['id']);
    echo '" class="btn btn-default btn-xs">';
    echo '<span class="glyphicon glyphicon-plus"></span> ';
    $this->lang('link_board_add');
    echo "</a></p>\n";
}
} ?>

<?php if(!empty($content['mails'])) { ?>
<table class="maillist striped">
<?php foreach($content['mails'] as $mail) {?>
    <tr onclick="jumpto(<?php echo $mail['id']; ?>);">
        <td><?php
            $this->lang('table_col_from');
            echo ' '.$mail['from'].' '; 
            $this->toDatetimeShort($mail['written']);
            echo '<br /><strong>';
            echo $mail['subject']; ?></strong></td>
    </tr>
<?php } ?>
</table>
<?php } ?>
<br />

<script>
    function showboard(id) {
        url = '<?php $this->buildURL('bbs/board/list/') ?>' + id;
        location.href = url;
    }
    function jumpto(id) {
        url = '<?php $this->buildURL('bbs/board/read/') ?>' + id;
        location.href = url;
    }
</script>

<?php include PATH_APP . '/modules/core/views/web/_elements/foot.php'; ?>