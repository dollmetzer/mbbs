<?php include PATH_APP . '/modules/core/views/frontend/_elements/head.php';

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
<p><a href="<?php echo $this->buildURL('bbs/board/new/'.$content['id']); ?>" class="btn"><i class="fa fa-pencil"></i>
 <?php $this->lang('btn_new_article'); ?></a></p>
<?php } ?>

<?php
if(in_array('administrator', $this->app->session->groups) && empty($content['board']['content'])) {
    echo '<p><a href="';
    echo $this->buildURL('bbs/adminboard/add/'.$content['id']);
    echo '" class="btn btn-default btn-xs">';
    echo '<i class="fa fa-plus"></i> ';
    $this->lang('link_board_add');
    echo "</a></p>\n";
}
?>

<?php if(!empty($content['themes'])) { ?>
<table class="maillist striped">
<?php foreach($content['themes'] as $theme) { ?>
    <tr onclick="showboard(<?php echo $theme['id']; ?>);">
        <td>
            <strong><?php echo $theme['name']; ?></strong><br /><?php echo $theme['description']; ?></a>
            <?php if(in_array('administrator', $this->app->session->groups)) { ?>
            <br /><a href="<?php $this->buildURL('bbs/adminboard/edit/'.$theme['id']); ?>" class="btn-small"><i class="fa fa-pencil"></i> <?php $this->lang('link_edit'); ?></a> 
                <a href="<?php $this->buildURL('bbs/adminboard/delete/'.$theme['id']); ?>" class="btn-small"><i class="fa fa-trash-o"></i> <?php $this->lang('link_delete'); ?></a>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>
<br />
<?php } ?>

<?php if(!empty($content['mails'])) { 
    include PATH_APP . '/modules/core/views/frontend/_elements/pagination.php';
?>
<table class="maillist striped">
<?php foreach($content['mails'] as $mail) {?>
    <tr onclick="jumpto(<?php echo $mail['id']; ?>);">
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

<?php include PATH_APP . '/modules/core/views/frontend/_elements/foot.php'; ?>