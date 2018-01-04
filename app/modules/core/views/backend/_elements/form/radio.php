<?php
if(!empty($field['inline'])) {
    $class = 'radio-inline';
} else {
    $class = 'radio';
}
foreach ($field['options'] as $oVal => $oName) {
    echo '<div class="'.$class.'"><label>';
    echo '<input id="formfield_'.$name.'" type="radio" name="' . $name . '" value="' . $oVal;
    if ($oVal == $field['value']) {
        echo '" checked="checked';
    }
    echo '" />&nbsp;';
    echo $oName . '&nbsp;&nbsp;&nbsp;';
    echo "</label></div>\n";
}
?>
