<?php include PATH_APP . '/modules/core/views/web/_elements/head.php'; ?>

<?php include PATH_APP . '/modules/core/views/web/_elements/form.php'; ?>

<?php if($this->app->config['register']['selfregister'] === true) { ?>
<hr />
<p><?php $this->lang('txt_not_registered'); ?></p>
<a class="btn" href="<?php $this->buildUrl('account/register'); ?>"><?php $this->lang('nav_register'); ?></a>
<?php } ?>

<?php include PATH_APP . '/modules/core/views/web/_elements/foot.php'; ?>