<?php
$content['nav_main'] = 'imprint';
include PATH_APP.'modules/core/views/frontend/_elements/head.php';

include PATH_APP.'modules/core/views/frontend/index/imprint_'.$this->session->user_language.'.php';

include PATH_APP.'modules/core/views/frontend/_elements/foot.php';
?>
