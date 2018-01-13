<?php
$content['nav_main'] = 'login';
include PATH_APP . 'modules/core/views/frontend/_elements/head.php';

include PATH_APP . 'modules/core/views/backend/_elements/form.php';
?>

<a href="<?php $this->buildURL('users/account/pwdreset'); ?>"><?php $this->lang('link_users_pwdreset'); ?></a>

<?php
include PATH_APP . 'modules/core/views/frontend/_elements/foot.php';
?>
