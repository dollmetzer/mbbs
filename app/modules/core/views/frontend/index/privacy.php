<?php
$content['nav_main'] = 'privacy';
include PATH_APP.'modules/core/views/frontend/_elements/head.php';

include PATH_APP.'modules/core/views/frontend/index/privacy_'.$this->session->user_language.'.php';

include PATH_APP.'modules/core/views/frontend/_elements/foot.php';
?>
