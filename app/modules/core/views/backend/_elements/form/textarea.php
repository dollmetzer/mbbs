<?php

    echo '<textarea id="formfield_'.$name.'" name="' . $name;
    if (!empty($field['rows'])) {
        echo '" rows="' . $field['rows'];
    }
    if (!empty($field['maxlength'])) {
        echo '" maxlength="' . (int)$field['maxlength'];
    }
    if (!empty($field['placeholder'])) {
        echo '" placeholder="' . $field['placeholder'];
    }
    echo '" class="form-control">';
    if (!empty($field['value'])) {
        echo $field['value'];
    }
    echo "</textarea>\n";

?>