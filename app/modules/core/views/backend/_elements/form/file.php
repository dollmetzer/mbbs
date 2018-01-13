<?php

    echo '<input id="formfield_'.$name.'" type="file" name="'.$name;
    if(!empty($field['accept'])) {
        echo '" accept="'.$field['accept'];
    }
    echo '" />';

?>