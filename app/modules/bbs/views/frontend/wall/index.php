<?php include PATH_APP . '/modules/core/views/frontend/_elements/head.php'; ?>

<div id="inputform" style="display:none;">
        
    <form action="<?php $this->buildURL('bbs/wall/new'); ?>" name="mailform" method="post" enctype="multipart/form-data">
    <input id="formfield_image" type="hidden" name="image" value="" />
    <p>
        <label for='subject'><?php $this->lang('label_subject'); ?>&nbsp;<sup>*</sup></label>
        <input type="text" class="form-control" name="subject" maxlength="80" value="" />
    </p>
    <p>
        <label for='message'><?php $this->lang('label_message'); ?></label>
        <textarea class="form-control" name="message" rows="8"></textarea>        
    </p>
    <p id="formblock_picture">
        <label for="pic"><?php $this->lang('label_picture'); ?></label>
        <input type="file" id="formfield_picture" name="pic" />
    </p>
    <p class="photo" id="itemphoto" style="display:none;">
        <label for="pic"><?php $this->lang('label_picture'); ?></label>
        <img src="about:blank" alt="" id="show-picture" style="width:60%">
    </p>

    <p>
        <a href="#" class="btn btn-ok" onclick="document.mailform.submit();"><i class="fa fa-check"></i> <?php $this->lang('link_send'); ?></a>
    </p>
    <p>
        <a href="#" class="btn btn-cancel" onclick="$('#inputswitch').slideToggle('slow');$('#inputform').slideToggle('slow');"><i class="fa fa-times"></i> <?php $this->lang('link_cancel'); ?></a>
    </p>
</form>
</div>

<div id="inputswitch">
    <p><a href="#" onclick="$('#inputswitch').slideToggle('slow');$('#inputform').slideToggle('slow');" class="btn"><i class="fa fa-pencil"></i> <?php $this->lang('link_new_entry'); ?></a></p>
</div>

<?php if(empty($content['mails'])) { ?>
<p><strong><?php $this->lang('msg_no_mails'); ?></strong></p>
<?php } else { ?>

<?php include PATH_APP . '/modules/core/views/frontend/_elements/pagination.php'; ?>

<table class="maillist striped">
<?php foreach($content['mails'] as $mail) {?>
    <tr onclick="jumpto(<?php echo $mail['id']; ?>);">
        <td><?php $this->lang('table_col_from'); ?> <?php echo $mail['from']; ?>
            <?php echo $this->toDatetimeShort($mail['written'], false); ?>
            <?php if(!empty($mail['picture'])) { echo '&nbsp;<i class="fa fa-photo"></i>'; } ?>
            <?php if(!empty($mail['attachments'])) { echo '<i class="fa fa-paperclip"></i>'; } ?>
            <br />
            <strong><?php echo $mail['subject']; ?></strong></td>
    </tr>
<?php } ?>
</table>
<?php } ?>

<?php include PATH_APP . '/modules/core/views/frontend/_elements/pagination.php'; ?>

<script type="text/javascript">
    function jumpto(id) {
        url = '<?php $this->buildURL('bbs/wall/read/') ?>' + id;        
        location.href = url;
    }
    <?php include PATH_APP . 'modules/bbs/views/frontend/_elements/resizeupload.js' ?>
</script>

<?php include PATH_APP . '/modules/core/views/frontend/_elements/foot.php'; ?>