<?php include PATH_APP . '/modules/core/views/web/_elements/head.php'; ?>

<p class="photo" id="itemphoto" style="display:none;">
    <label for="pic"><?php $this->lang('form_label_picture'); ?></label>
    <img src="about:blank" alt="" id="show-picture" style="width:60%">
</p>
    
<?php include PATH_APP . '/modules/core/views/web/_elements/form.php'; ?>

<script type="text/javascript">
    <?php include PATH_APP . 'modules/bbs/views/web/_elements/resizeupload.js' ?>
</script>

<?php include PATH_APP . '/modules/core/views/web/_elements/foot.php'; ?>