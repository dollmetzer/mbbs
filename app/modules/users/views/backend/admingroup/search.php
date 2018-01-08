<?php
$content['nav_main'] = 'admingroup';
include PATH_APP.'modules/core/views/backend/_elements/head.php';


if(empty($content['table'])) {

    echo '<p>'.sprintf($this->lang('msg_no_searchresult', false), $content['searchterm'])."</p>\n";

} else {

    if($content['table']->getRows() > 0) {
        echo '<p>'.sprintf($this->lang('msg_searchresult_for', false), $content['searchterm'])."</p>\n";
        include PATH_APP.'modules/core/views/backend/_elements/table.php';
    } else {
        echo '<p>'.sprintf($this->lang('msg_no_searchresult', false), $content['searchterm'])."</p>\n";
    }

}

include PATH_APP.'modules/core/views/backend/_elements/foot.php';
?>