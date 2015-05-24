<?php include PATH_APP . '/modules/core/views/web/_elements/head.php'; ?>

<div id="inputform" style="display:none;">
    <form action="<?php $this->buildURL('bbs/wall/new'); ?>" name="mailform" method="post" role="form">
    <p>
        <label for='subject'>Betreff&nbsp;<sup>*</sup></label>
        <input type="text" class="form-control" name="subject" maxlength="80" value="" />
    </p>
    <p>
        <label for='message'>Nachricht</label>
        <textarea class="form-control" name="message" rows="8"></textarea>        
    </p>    
    <p>
        <label for='submit'>&nbsp;</label>
        <a href="#" class="btn btn-ok" onclick="document.mailform.submit();"><i class="fa fa-check"></i> absenden</a>
    </p>
    <p>
        <label for='submit'>&nbsp;</label>
        <a href="#" class="btn btn-cancel" onclick="$('#inputswitch').slideToggle('slow');$('#inputform').slideToggle('slow');"><i class="fa fa-times"></i> abbrechen</a>
    </p>
</form>
</div>

<div id="inputswitch">
    <p><a href="#" onclick="$('#inputswitch').slideToggle('slow');$('#inputform').slideToggle('slow');" class="btn"><i class="fa fa-pencil"></i> <?php $this->lang('link_new_entry'); ?></a></p>
</div>

<?php if(empty($content['mails'])) { ?>
<p><strong><?php $this->lang('msg_no_mails'); ?></strong></p>
<?php } else { ?>

<table class="maillist striped">
<?php foreach($content['mails'] as $mail) {?>
    <tr onclick="jumpto(<?php echo $mail['id']; ?>);">
        <td><?php $this->lang('table_col_from'); ?> <?php echo $mail['from']; ?>
            <?php echo $this->toDatetimeShort($mail['written'], false); ?><br />
            <strong><?php echo $mail['subject']; ?></strong></td>
    </tr>
<?php } ?>
</table>
<?php } ?>

<script type="text/javascript">
    function jumpto(id) {
        url = '<?php $this->buildURL('bbs/wall/read/') ?>' + id;        
        location.href = url;
    }
</script>

<?php include PATH_APP . '/modules/core/views/web/_elements/foot.php'; ?>