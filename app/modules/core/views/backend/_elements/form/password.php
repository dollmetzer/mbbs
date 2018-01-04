<?php

    echo '<input id="formfield_'.$name.'" type="password" name="';
    echo $name . '" ';
    if (!empty($field['maxlength'])) {
        echo 'maxlength="' . (int)$field['maxlength'] . '" ';
    }
    echo 'value="" class="form-control" />';

?>