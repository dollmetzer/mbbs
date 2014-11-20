<?php include PATH_APP . '/modules/core/views/web/_elements/head.php'; ?>

<p><?php $this->lang('txt_import_intro'); ?></p>

<form action="" method="post" enctype="multipart/form-data">
    <p><input type="file" name="mails" onchange="submit();"/></p>
</form>

<?php include PATH_APP . '/modules/core/views/web/_elements/foot.php'; ?>