<?php
$content['nav_main'] = 'terms';
include PATH_APP.'modules/core/views/frontend/_elements/head.php';

include PATH_APP.'modules/core/views/frontend/index/terms_'.$this->session->user_language.'.php';

include PATH_APP.'modules/core/views/frontend/_elements/foot.php';
?>
