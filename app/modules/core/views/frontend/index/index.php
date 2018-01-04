<?php
$content['nav_main'] = 'home';
include PATH_APP.'modules/core/views/frontend/_elements/head.php';

include PATH_APP.'modules/core/views/frontend/index/index_'.$this->session->user_language.'.php';

include PATH_APP.'modules/core/views/frontend/_elements/foot.php';
?>